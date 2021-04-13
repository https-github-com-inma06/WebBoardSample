<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php"; /* db load */
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script type="text/javascript" src="/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
</head>
<body>
<?php
$b_no = $_GET['idx']; /* 글목록에서 선택한 글의 idx값을 GET으로 받아옴 */
$hit = mysqli_fetch_array(mq("SELECT * FROM board WHERE idx ='" . $b_no . "'")); /* 조회수*/
$hit = $hit['hit'] + 1;  /*조회수 1증가 TODO: 동일한 유저가 조회수 늘리는것 방지해야함*/
$fet = mq("UPDATE board SET hit = '" . $hit . "' WHERE idx = '" . $b_no . "'"); // 해당 idx에 hit(조회수) 수정
$sql = mq("SELECT * FROM board WHERE idx='" . $b_no . "'"); /* 받아온 idx값을 선택 */
$board = $sql->fetch_array(); /*해당 idx의 모든 칼럼에 값을 가져옴*/
?>
<!-- 글 불러오기 -->
<div id="board_read">
    <!-- 제목-->
<!--    <div id="board_title">-->
<!--        --><?php //echo "<h1>제목 : " . $board['title']. "</h1>"; ?>
<!--    </div>-->
    <div id="bo_line"></div>
    <!-- 작성자, 작성일, 조회수-->
    <?php echo "<h1>　" . $board['title']. "</h1>"; ?>
    <div id="user_info">
        <?php echo "작성자 : " . $board['name']; ?> <br>
        <?php echo "작성일 : " . $board['date']; ?> <br>
        <?php echo "조회수 : " . $board['hit']; ?> <br>
    </div>
    <div id="bo_line"></div>
    <!-- 목록, 수정, 삭제 -->
    <div id="bo_ser">
        <ul>
            <li><a href="/">[목록으로]</a></li>
            <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
            <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
        </ul>
    </div>

    <!-- 글내용-->
    <div id="bo_content">
        <?php echo nl2br("$board[content]"); ?>
    </div>

    <!-- 첨부파일 -->
    <div id="bo_file">
        <?php if($board['file_id'] == null) {
            echo "[첨부파일]";
        } else {
        ?>
        <a href="download.php?file_id=<?php echo $board['file_id'] ?>" target="_blank">
            <?php echo "[첨부파일] " . $board['name_orig'] ?>
        </a>
        <?php
        }?>

    </div>

    <!--- 댓글 불러오기 -->
    <div class="reply_view">
        <h3>댓글목록</h3>
        <?php
        $sql2 = mq("SELECT * FROM reply WHERE con_num='" . $b_no . "' order by idx asc"); /* 최근 댓글이 하단으로 오게 ( 오름차순 )*/
        while ($reply = $sql2->fetch_array()) {
            ?>

            <div class="dap_lo">
                <div><b><?php echo $reply['name']; ?></b></div> <!-- 댓글 작성자 이름 -->
                <div class="dap_to comt_edit "><?php echo nl2br("$reply[content]"); ?></div>
                <div class="rep_me dap_to"><?php echo $reply['date']; ?></div> <!-- 댓글 작성시간 -->
                <div class="rep_me rep_menu">
                    <a class="dat_edit_bt" href="#">수정</a>
                    <a class="dat_delete_bt" href="#">삭제</a>
                </div>
                <!-- 댓글 수정 폼 dialog -->
                <div class="dat_edit">
                    <form method="post" action="reply_modify_ok.php">
                        <input type="hidden" name="r_no" value="<?php echo $reply['idx']; ?>"/>
                        <input type="hidden" name="b_no" value="<?php echo $b_no; ?>">
                        <input type="password" name="pw" class="dap_sm" placeholder="비밀번호"/>
                        <textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
                        <input type="submit" value="수정하기" class="re_mo_bt">
                    </form>
                </div>
                <!-- 댓글 삭제 비밀번호 확인 -->
                <div class='dat_delete'>
                    <form action="reply_delete.php" method="post">
                        <input type="hidden" name="r_no" value="<?php echo $reply['idx']; ?>"/>
                        <input type="hidden" name="b_no" value="<?php echo $b_no; ?>">
                        <p>비밀번호<input type="password" name="pw"/>
                            <input type="submit" value="확인">
                        </p>
                    </form>
                </div>
            </div>
        <?php } ?>

        <!--- 댓글 입력 폼 -->
        <div class="dap_ins">
            <form action="reply_ok.php?idx=<?php echo $b_no; ?>" method="post">
                <input type="text" name="dat_user" id="dat_user" class="dat_user" size="15" placeholder="닉네임">
                <input type="password" name="dat_pw" id="dat_pw" class="dat_pw" size="15" placeholder="비밀번호">
                <div style="margin-top:10px; ">
                    <textarea name="content" class="reply_content" id="re_content"></textarea>
                    <button id="rep_bt" class="re_bt">댓글</button>
                </div>
            </form>
        </div>
    </div><!--- 댓글 불러오기 끝 -->
    <div id="foot_box"></div>
</div>
</body>
</html>