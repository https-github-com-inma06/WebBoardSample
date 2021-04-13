<?php include $_SERVER['DOCUMENT_ROOT'] . "/db.php"; ?>

<?php error_reporting(E_ALL);
ini_set("display_errors", 1); ?>
<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>개발 소통</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
</head>

<body>

<!-- 게시판 영역 -->
<div class="container">
    <div id="index_title">
        <a href="/">
            <h1>개발 소통</h1>
        </a>
    </div>
    <h4>자유롭게 소통 해요</h4>

    <!-- 게시글 테이블 -->

    <table class="table table-hover">
        <!-- 테이블 상단 -->
        <thead>
        <tr>
            <th scope="col">번호</th>
            <th scope="col">제목</th>
            <th scope="col">글쓴이</th>
            <th scope="col">작성일</th>
            <th scope="col">조회수</th>
        </tr>
        </thead>
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $sql = mq("SELECT * FROM board");
        $row_num = mysqli_num_rows($sql); //게시판 총 레코드 수
        $list = 8; //한 페이지에 보여줄 개수
        $block_ct = 10; //블록당 보여줄 페이지 개수


        $block_num = ceil($page / $block_ct); // 현재 페이지 블록 구하기
        $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
        $block_end = $block_start + $block_ct - 1; //블록 마지막 번호

        $total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기
        if ($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
        $total_block = ceil($total_page / $block_ct); //블럭 총 개수
        $start_num = ($page - 1) * $list; //시작번호 (page-1)에서 $list를 곱한다.


        $sql2 = mq("SELECT * FROM board ORDER BY idx DESC limit $start_num, $list");
        while ($board = $sql2->fetch_array()) {
            //            if ($board['isDelete'] == "N") { // 게시글 삭제 유무 ( 레거시 )
            $title = $board["title"];
            if (strlen($title) > 60) {
                $title = str_replace($board["title"], mb_substr($board["title"], 0, 60, "utf-8") . "...", $board["title"]);
            }
            $sql3 = mq("SELECT * FROM reply WHERE con_num='" . $board['idx'] . "'");
            $rep_count = mysqli_num_rows($sql3);
            ?>
            <!-- 테이블 바디 -->
            <tbody>
            <tr>
                <td scope="row"><?php echo $board['idx']; ?></td>
                <td scope="row">

                    <!-- 비밀글, 첨부파일 이미지 표시 분기처리 -->
                    <?php
                    $lock_img = "<img src='/img/lock_post.png' alt='lock' title='lock' width='16' height='16' />";
                    $file_img = "<img src='/img/file_up.png' alt='file_up' title='file_up' width='16' height='16' />";
                    /* 비밀글이면서 첨부파일 없을때 */
                    if ($board['lock_post'] == "1" && $board['file_id'] == null)
                    { ?>
                    <a href='/page/board/lock_read.php?idx=<?php echo $board["idx"]; ?>'>
                        <?php echo $title, $lock_img; // 제목 옆에 비밀글 이미지 표시
                        }
                        /* 비밀글이고 첨부파일도 있을 때 */
                        else if ($board['lock_post'] == "1" && $board['file_id'] != null) { ?>
                        <a href='/page/board/lock_read.php?idx=<?php echo $board["idx"]; ?>'>
                            <?php echo $title, $lock_img, $file_img; // 제목 옆에 비밀글, 첨부 이미지 표시
                            ?> <?php
                            }
                            /* 첨부파일만 있을 때 */
                            else if ($board['lock_post'] != "1" && $board['file_id'] != null){ ?>
                            <a href='/page/board/read.php?idx=<?php echo $board["idx"]; ?>'>
                                <?php echo $title, $file_img; // 제목 옆에 첨부 이미지만 표시
                                } else { ?>
                                <a href='/page/board/read.php?idx=<?php echo $board["idx"]; ?>'>
                                    <?php echo $title;
                                    } ?> <!-- 제목만 표시-->
                                    <span class="re_ct">[<?php echo $rep_count; ?>]</span></a> <!-- 댓글 개수 표시 -->
                </td>
                <td scope="row"><?php echo $board['name'] ?></td>
                <td scope="row"><?php echo $board['date'] ?></td>
                <td scope="row"><?php echo $board['hit']; ?></td>
            </tr>
            </tbody>


            <?php
        } ?>
    </table>


    <!-- 페이징 넘버 -->
    <div id="page_num">
        <ul>
            <?php
            if ($page <= 1) { //만약 page가 1보다 크거나 같다면
                echo "<li class='fo_re'>처음</li>"; //처음이라는 글자에 빨간색 표시
            } else {
                echo "<li><a href='?page=1'>처음</a></li>"; //알니라면 처음글자에 1번페이지로 갈 수있게 링크
            }
            if ($page <= 1) { //만약 page가 1보다 크거나 같다면 빈값

            } else {
                $pre = $page - 1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                echo "<li><a href='?page=$pre'>이전</a></li>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
            }
            for ($i = $block_start;
                 $i <= $block_end;
                 $i++) {
                //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
                if ($page == $i) { //만약 page가 $i와 같다면
                    echo "<li class='fo_re'>[$i]</li>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                } else {
                    echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 $i
                }
            }
            if ($block_num >= $total_block) { //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
            } else {
                $next = $page + 1; //next변수에 page + 1을 해준다.
                echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
            }
            if ($page >= $total_page) { //만약 page가 페이지수보다 크거나 같다면
                echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
            } else {
                echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
            }
            ?>
        </ul>
    </div>
    <div id="write_btn">
        <a href="/page/board/write.php">
            <button type="button" class="btn btn-warning">글쓰기</button>
        </a>
    </div>


</div>


</body>
</html>