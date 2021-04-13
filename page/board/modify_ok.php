<?php
include $_SERVER['DOCUMENT_ROOT']."/db.php";

$bno = $_GET['idx'];
$username = $_POST['name'];
$userPw = $_POST['pw'];
$title = $_POST['title'];
$content = $_POST['content'];
$sql = mq("SELECT pw FROM board WHERE idx='".$bno."'"); /* 받아온 idx값을 선택 */
$dbPw = $sql->fetch_array(); /*해당 idx의 pw 칼럼에 값을 가져옴*/

if( $bno != null && // null 체크 부분
    $username != null &&
    $title != null &&
    $content != null) {
    /*패스워드를 검증*/
    if(password_verify($userPw, $dbPw['pw'])) {
        $sql = mq("update board set name='".$username."',title='".$title."',content='".$content."' where idx='".$bno."'");
        echo '<script type="text/javascript">alert("수정되었습니다."); </script>';
        echo '<meta http-equiv="refresh" content="0 url=/page/board/read.php?idx='.$bno.';">';
    } else {
        echo '<script type="text/javascript">alert("비밀번호를 확인하세요."); </script>';
        echo '<script> history.back();</script>';
    }
} else {
    echo '<script type="text/javascript">alert("잘못된 접근입니다"); </script>';
    echo "<script>location.href='/';</script>";
 }
$sql->closeAll();
