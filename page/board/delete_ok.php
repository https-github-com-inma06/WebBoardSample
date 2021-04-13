<?php
include $_SERVER['DOCUMENT_ROOT']."/db.php";

$bno = $_POST['idx']; // 글번호
$userPw = $_POST['pw']; // 패스워드
$isDelete = "Y"; // 레거시 방식
$sql1 = mq("SELECT pw FROM board WHERE idx='".$bno."'"); // DB에서 idx에 해당하는 패스워드를 가져옴
$getDbPw = $sql1->fetch_array();
$sql1->close();

/* 예외처리 부분 */
if( $bno != null && // null 체크 부분
    $userPw != null) {
    /*패스워드 검증*/
    if(password_verify($userPw, $getDbPw['pw'])) {

        try {
            $sql2 = mq("INSERT INTO board_delete SELECT * FROM board WHERE idx='$bno';"); // 삭제 게시글 다른 테이블로 옮기기
            $sql3 = mq("DELETE FROM board WHERE idx='$bno';"); // 게시글 삭제
            //        $sql = mq("UPDATE board SET isDelete='".$isDelete."' WHERE idx='".$bno."'"); // 레거시 코드 - Y / N 수정 (글 보이기 숨기기)
        } catch (Exception $e) {
            echo $e;
        }
        echo '<script type="text/javascript">alert("삭제되었습니다."); </script>';
        echo '<meta http-equiv="refresh" content="0 url=/">';
    } else {
        echo '<script type="text/javascript">alert("비밀번호를 확인하세요."); </script>';
        echo '<script> history.back();</script>';
    }
} else {
    echo '<script type="text/javascript">alert("잘못된 접근입니다"); </script>';
    echo "<script>location.href='/';</script>";
}
