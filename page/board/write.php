<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>개발 소통</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div id="board_write">
    <div id="index_title">
        <a href="/">
            <h1>개발 소통</h1>
        </a>
    </div>
    <h4>자유롭게 소통 해요</h4>
    <div id="write_area">
        <form action="write_ok.php" method="post" enctype="multipart/form-data">
            <!--제목 -->
            <div id="in_title">
                <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100"
                          required></textarea>
            </div>
            <div class="wi_line"></div>
            <!-- 작성자 -->
            <div id="in_name">
                <textarea name="name" id="uname" rows="1" cols="55" placeholder="글쓴이" maxlength="100"
                          required></textarea>
            </div>
            <!-- 파일업로드 -->
            <div>
                <label for="in_file">첨부파일</label>
                <input type="file" value="1" name="b_file"/>
            </div>
            <div class="wi_line"></div>
            <!-- 본문 -->
            <div id="in_content">
                <textarea name="content" id="ucontent" placeholder="내용" required></textarea>
            </div>
            <!-- 비밀번호 -->
            <div id="in_pw">
                <input type="password" name="pw" id="upw" placeholder="비밀번호" required/>
            </div>
            <!-- 게시글 잠금 여부 설정 -->
            <div id="in_lock">
                <input type="checkbox" value="Y" name="post_lock"/>해당글을 잠급니다.
            </div>
            <div class="bt_se">
                <button type="submit">글 작성</button>
            </div>
        </form>
    </div>
</div>
</body>


<!-- 스크립트 -->
<script type="text/javascript">
    function uploadForm(f) {
        // 업로드 할 수 있는 파일 확장자를 제한합니다.
        var extArray = new Array('hwp', 'xls', 'doc', 'xlsx', 'docx', 'pdf', 'jpg', 'gif', 'png', 'txt', 'ppt', 'pptx');
        var path = document.getElementById("upfile").value;
        if (path == "") {
            alert("파일을 선택해 주세요.");
            return false;
        }
        var pos = path.indexOf(".");
        if (pos < 0) {
            alert("확장자가 없는파일 입니다.");
            return false;
        }
        var ext = path.slice(path.indexOf(".") + 1).toLowerCase();
        var checkExt = false;
        for (var i = 0; i < extArray.length; i++) {
            if (ext == extArray[i]) {
                checkExt = true;
                break;
            }
        }
        if (checkExt == false) {
            alert("업로드 할 수 없는 파일 확장자 입니다.");
            return false;
        }
        return true;
    }
</script>


</html>