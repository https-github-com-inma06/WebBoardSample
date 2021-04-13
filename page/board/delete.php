<?php
include $_SERVER['DOCUMENT_ROOT']."/db.php"; /* db load */
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<?php
$bno = $_GET['idx']; /* 글목록에서 선택한 글의 idx값을 GET으로 받아옴 */
?>
<!-- 글삭제 -->
<div id="delete_verify">
    <form action="delete_ok.php" method="post">
        <div id="delete_bno">
            <textarea name="idx" id="ubno" required hidden><?php echo $bno; ?></textarea>
        </div>
        <div id="delete_password" align="center">
            <input type="password" name="pw" id="upw"  placeholder="비밀번호" required />
        </div>
        <div class="bt_se" id="delete_btn">
            <button type="submit">글 삭제</button>
        </div>
    </form>
    <div class="bt_se" id="index">
        <a href="/index.php"><button type="submit">글 목록 </button></a>
    </div>
</div>
</body>
</html>