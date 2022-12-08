<?php
require_once('../../../../connection.php');
session_start();
$limit = $_POST['results-per-page'];
if ($_POST["page"] > 1) {
    $start = (($_POST["page"] - 1) * $limit);
    $page = $_POST["page"];
} else {
    $page = 1;
    $start = 0;
}
if (isset($_SESSION['id_user'])) {
    $userId = $_SESSION['id_user'];
    $query =
        "SELECT user_log.id, movie_schedule.id, movie.id, movie.title, genre.name, movie_schedule.id_room, DATE(movie_schedule.date_begin), TIME_FORMAT(TIME(movie_schedule.date_begin), '%H:%i')
        FROM user_log
        INNER JOIN movie_schedule ON user_log.id_session = movie_schedule.id 
        INNER JOIN movie ON movie_schedule.id_movie = movie.id
        INNER JOIN movie_genre ON movie.id = movie_genre.id_movie 
        INNER JOIN genre ON movie_genre.id_genre = genre.id
        WHERE user_log.id_user LIKE :id
        ORDER BY DATE(movie_schedule.date_begin) DESC";
    $sample_data = array(
        ':id'        =>    $userId
    );
    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
    $statement = $conn->prepare($query);
    $statement->execute($sample_data);
    $total_data = $statement->rowCount();
    $statement = $conn->prepare($filter_query);
    $statement->execute($sample_data);
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $data[] = array(
            'title'            =>    $row[3],
            'genre'            =>    $row[4],
            'room'            =>    $row[5],
            'sessionDate'            =>    $row[6],
            'sessionHour'            =>    $row[7],
        );
    }
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
                    $previous_link = '<li class="page-item"><a class="page-link bg-dark text-white" href="javascript:userHistory(' . $limit . ', ' . $previous_id . ')">Previous</a></li>';
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
				<li class="page-item"><a class="page-link bg-dark text-white" href="javascript:userHistory(' . $limit . ', '  . $next_id . ')">Next</a></li>
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
					<a class="page-link bg-dark text-white" href="javascript:userHistory(' . $limit . ', '  . $page_array[$count] . ')">' . $page_array[$count] . '</a>
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
        'data'        =>    $data,
        'total_data'        =>    $total_data,
        'pagination'        =>    $pagination_html,
    );
    echo json_encode($output);
}
