<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
$r_no = $_POST['r_no'];
$sql = mq("SELECT * FROM reply WHERE idx='" . $r_no . "'");//reply테이블에서 idx가 rno변수에 저장된 값을 찾음
$reply = $sql->fetch_array();

$b_no = $_POST['b_no'];
$sql2 = mq("SELECT * FROM board WHERE idx='" . $b_no . "'");//board테이블에서 idx가 bno변수에 저장된 값을 찾음
$board = $sql2->fetch_array();

$input_pw = $_POST['pw'];
$db_pw = $reply['pw'];

if (password_verify($input_pw, $db_pw)) {

    /* TODO: 댓글 삭제의 경우 UPDATE 로 isDelete 칼럼을 Y로 표기해 줘서 DB를 남겨둔다.
        주의할 사항은 read.php 부분에서 댓글을 보여줄때
        조건문으로 isDelete == N 처리 해줘야 삭제하지 않은 댓글들이 출력된다.
        귀찮기 때문에 나중에하자^ㅇ^
    */
    $sql = mq("DELETE FROM reply WHERE idx='" . $r_no . "'"); ?>
    <script type="text/javascript">alert('댓글이 삭제되었습니다.');
        location.replace("read.php?idx=<?php echo $board["idx"]; ?>");
    </script>
    <?php
} else { ?>
    <script type="text/javascript">alert('비밀번호가 틀립니다');
        history.back();
    </script>
<?php } ?>