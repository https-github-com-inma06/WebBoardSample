<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
$r_no = $_POST['r_no'];//댓글번호
$sql = mq("SELECT * FROM reply WHERE idx='" . $r_no . "'"); //reply테이블에서 idx가 rno변수에 저장된 값을 찾음
$reply = $sql->fetch_array();
$b_no = $_POST['b_no']; //게시글 번호
$sql2 = mq("SELECT * FROM board WHERE idx='" . $b_no . "'");//board테이블에서 idx가 bno변수에 저장된 값을 찾음
$board = $sql2->fetch_array();

$input_pw = $_POST['pw'];
$db_pw = $reply['pw'];

// reply 테이블의 idx가 rno변수에 저장된 값의 content를 선택해서 값 저장
// 수정시 비밀번호 체크
if (password_verify($input_pw, $db_pw)) {
    $sql = mq("UPDATE reply SET content='" . $_POST['content'] . "' WHERE idx = '" . $r_no . "'"); ?>
    <script type="text/javascript">
        alert('수정되었습니다.');
        location.replace("read.php?idx=<?php echo $b_no; ?>");
    </script>
    <?php
} else { ?>
    <script type="text/javascript">alert('비밀번호가 틀립니다');
        history.back();
    </script>
<?php } ?>

