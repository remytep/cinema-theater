<?php
require_once('../../connection.php');

$baseQuery = "
SELECT movie.id, movie.title, movie.director, distributor.name, genre.name, CONCAT(FLOOR(movie.duration/60),'h ',MOD(movie.duration,60),'m'), movie.rating 
FROM movie 
INNER JOIN distributor ON distributor.id = movie.id_distributor
INNER JOIN movie_genre ON movie.id = movie_genre.id_movie 
INNER JOIN genre ON movie_genre.id_genre = genre.id
";


// Défintion des valeurs pour la pagination
$page = 1;
$limit = $_POST['results-per-page'];
if ($_POST["page"] > 1) {
    $start = (($_POST["page"] - 1) * $limit);
    $page = $_POST["page"];
} else {
    $start = 0;
}

// Execution de la requête SQL pour récupérer les résultats qui match l'input
if (isset($_POST['movie-title']) && isset($_POST['movie-distributor']) && isset($_POST['movie-genre']) && isset($_POST['results-per-page'])) {
    // Définition des variables pour plus de lisibilité
    $movieTitle = $_POST['movie-title'];
    $movieDistributor = $_POST['movie-distributor'];
    $movieGenre = $_POST['movie-genre'];
    $data = array();
    if (($movieTitle != '' || $movieDistributor != '') || $movieGenre != '') {
        // Cas où l'utilisateur input soit du texte soit un genre
        $sample_data = array(
            ':title'        =>    '%' . $movieTitle . '%',
            ':distributor'        =>    '%' . $movieDistributor . '%'
        );
        if ($movieGenre == 'all') {
            // Cas où aucun genre n'est sélectionné
            $query = $baseQuery . "
		    WHERE movie.title LIKE :title
            AND distributor.name LIKE :distributor
            ORDER BY id ASC
		    ";
            $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
        } else {
            // Cas où un genre est séléctionné
            $sample_data[':genre'] = '%' . $movieGenre . '%';
            $query = $baseQuery . "
            WHERE movie.title LIKE :title 
            AND distributor.name LIKE :distributor
            AND genre.name LIKE :genre
            ORDER BY id ASC
            ";
        }
        $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
        $statement = $conn->prepare($query);
        $statement->execute($sample_data);
        $total_data = $statement->rowCount();
        $statement = $conn->prepare($filter_query);
        $statement->execute($sample_data);
        $result = $statement->fetchAll();
        // Ajout des données dans le tableau sous forme d'objet
        foreach ($result as $row) {
            $data[] = array(
                'id'            =>    $row[0],
                'title'            =>    $row[1],
                'director'            =>    $row[2],
                'distributor'            =>    $row[3],
                'genre'            =>    $row[4],
                'duration'            =>    $row[5],
                'rating'            =>    $row[6]
            );
        }
    } else {
        // Cas de base (lors du page loading, aucun filtre ou d'un refresh)
        $query = $baseQuery . "
        ORDER BY id ASC
		";
        $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
        $statement = $conn->prepare($query);
        $statement->execute();
        $total_data = $statement->rowCount();
        $statement = $conn->prepare($filter_query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $data[] = array(
                'id'            =>    $row[0],
                'title'            =>    $row[1],
                'director'            =>    $row[2],
                'distributor'            =>    $row[3],
                'genre'            =>    $row[4],
                'duration'            =>    $row[5],
                'rating'            =>    $row[6]
            );
        }
    }
    // Pagination
    $pagination_html = '
	<div align="center">
  		<ul class="pagination justify-content-center">
	';

    $total_links = ceil($total_data / $limit);
    if ($total_links == 0) {
        $data = [];
    } else {
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        // Permet de gérer le nombre de liens générés en fonction du nombre de résultats
        if ($total_links > 4) {
            if ($page < 5) {
                for ($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if ($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for ($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }
        // HTML à insérer
        for ($count = 0; $count < count($page_array); $count++) {
            if ($page == $page_array[$count]) {
                $page_link .= '
			<li class="page-item active">
	      		<a class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></a>
	    	</li>
			';
                $previous_id = $page_array[$count] - 1;
                if ($previous_id > 0) {
                    $previous_link = '<li class="page-item"><a class="page-link bg-dark text-white" href="javascript:movieLoad(`' . $movieTitle . '`,`' . $movieDistributor . '`,`' . $movieGenre . '`, ' . $previous_id . ')">Previous</a></li>';
                } else {
                    $previous_link = '
				<li class="page-item disabled">
			        <a class="page-link bg-dark" href="#">Previous</a>
			    </li>
				';
                }
                $next_id = $page_array[$count] + 1;
                if ($next_id > $total_links) {
                    $next_link = '
				<li class="page-item disabled">
	        		<a class="page-link bg-dark" href="#">Next</a>
	      		</li>
				';
                } else {
                    $next_link = '
				<li class="page-item"><a class="page-link bg-dark text-white" href="javascript:movieLoad(`' . $movieTitle . '`,`' . $movieDistributor . '`,`' . $movieGenre . '`, ' . $next_id . ')">Next</a></li>
				';
                }
            } else {
                if ($page_array[$count] == '...') {
                    $page_link .= '
				<li class="page-item disabled">
	          		<a class="page-link bg-dark" href="#">...</a>
	      		</li>
				';
                } else {
                    $page_link .= '
				<li class="page-item">
					<a class="page-link bg-dark text-white" href="javascript:movieLoad(`' . $movieTitle . '`,`' . $movieDistributor . '`,`' . $movieGenre . '`, ' . $page_array[$count] . ')">' . $page_array[$count] . '</a>
				</li>
				';
                }
            }
        }

        $pagination_html .= $previous_link . $page_link . $next_link;
        $pagination_html .= '
		</ul>
	</div>
	';
    }
    $output = array(
        'data'                =>    $data,
        'pagination'        =>    $pagination_html,
        'total_data'        =>    $total_data
    );

    echo json_encode($output);
}
