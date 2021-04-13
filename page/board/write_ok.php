<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);
//각 변수에 write.php에서 input name값들을 저장한다
/* TODO: 비로그인으로 글을 작성하면 닉네임 옆에 아이피 주소를 출력한다
    EX: nickname(123.123.*.*)
*/

/* 게시글 작성 */
$username = $_POST['name']; // 글쓴이
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT); // 패스워드 ( 암호화 기본함수 PHP5 버전 이상부터 )
$title = $_POST['title']; // 제목
$content = $_POST['content']; // 글내용
$date = date('Y-m-d H:i:s'); // 작성 년-월-일 시간:분
if (isset($_POST['post_lock'])) {
    $lock_post = '1';  // 비밀글이면 (Y->true) 라면 1
} else {
    $lock_post = '0'; // 비밀글이 아니면 (N->false) 아니면 0
}
//if ($username && $userpw && $title && $content) { // 글쓴이, 패스워드, 제목, 내용 Null 체크
////    $sql = mq("INSERT INTO board(name,pw,title,content,date,lock_post) VALUES (
////                '" . $username . "','" . $userpw . "','" . $title . "','" . $content . "','" . $date . "','" . $lock_post . "')"
////    ); // SQL문 INSERT 생성(CREATE) INTO "테이블명"(칼럼명,...,...,...) VALUES(POST 전달받은 값. 각 칼럼에 들어갈 입력값 순)
////     정상처리시 알림창 띄움
//    echo "<script>alert('글쓰기 완료되었습니다.'); location.href='/';</script>"; // 글목록 페이지 ( root directory ) 으로 이동
//} else {
//    echo "<script>
//    alert('글쓰기에 실패했습니다.'); // 비정상 처리시
//    history.back();</script>"; // 이전 페이지로 이동
//}


/* 파일 업로드 */
//if ($username && $userpw && $title && $content) {
    if (isset($_FILES['b_file']) && $_FILES['b_file']['name'] != "") {
        $file = $_FILES['b_file'];
        $upload_directory = 'data/';
        $ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,gif,png,txt,ppt,pptx";
        $allowed_extensions = explode(',', $ext_str);
        $max_file_size = 5242880;
        $ext = substr($file['name'], strrpos($file['name'], '.') + 1);

        // 확장자 체크
        if (!in_array($ext, $allowed_extensions)) {
            echo "업로드할 수 없는 확장자 입니다.";
        }

        // 파일 크기 체크
        if ($file['size'] >= $max_file_size) {
            echo "5MB 까지만 업로드 가능합니다.";
        }
        $path = md5(microtime()) . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $upload_directory . $path)) {
            $file_id = md5(uniqid(rand(), true));
            $name_orig = $file['name'];
            $name_save = $path;
            $sql = mq("INSERT INTO board(name,pw,title,content,date,lock_post, file_id, name_orig, name_save) VALUES (
                '" . $username . "','" . $userpw . "','" . $title . "','" . $content . "','" . $date . "','" . $lock_post . "',
                 '" . $file_id . "', '" . $name_orig . "', '" . $name_save . "')"
            );
        }
        echo "<script>alert('글쓰기 완료되었습니다.'); location.href='/';</script>"; // 글목록 페이지 ( root directory ) 으로 이동
    } else if($username && $userpw && $title && $content) {
        $sql = mq("INSERT INTO board(name,pw,title,content,date,lock_post) VALUES (
                '" . $username . "','" . $userpw . "','" . $title . "','" . $content . "','" . $date . "','" . $lock_post . "')"
        );
        echo "<script>alert('글쓰기 완료되었습니다.'); location.href='/';</script>"; // 글목록 페이지 ( root directory ) 으로 이동
    }
//} else {
//    echo "<script>alert('잘못된 접근입니다');</script>"; // 글목록 페이지 ( root directory ) 으로 이동
//    echo '<a href="javascript:history.go(-1);">이전 페이지</a>';
//}

/*else {
    echo "<script>alert('일시적인 오류로 글쓰기에 실패하였습니다.');</script>"; // 글목록 페이지 ( root directory ) 으로 이동
    echo '<a href="javascript:history.go(-1);">이전 페이지</a>';
}*/

