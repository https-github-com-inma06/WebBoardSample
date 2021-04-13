<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php"; /* db load */
?>
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css"/>
    <script type="text/javascript" src="/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#writepass").dialog({
                modal: true,
                title: '비밀글입니다.',
                width: 400,
            });
        });
    </script>
<?php

$bno = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/
$sql = mq("SELECT * FROM board WHERE idx='".$bno."'"); /* 받아온 idx값을 선택 */
$board = $sql->fetch_array();

?>
    <div id='writepass'>
        <form action="" method="post">
            <p align="center">비밀번호<input type="password" name="pw_chk"/> <input type="submit" value="확인"/></p>
        </form>
        <p align="center">
            <a href="/index.php">
                <button type="submit">글 목록</button>
            </a>
        </p>
    </div>

<?php
$dbPw = $board['pw'];

if (isset($_POST['pw_chk'])) //만약 pw_chk POST값이 있다면
{
    $pwk = $_POST['pw_chk']; // $pwk변수에 POST값으로 받은 pw_chk를 넣습니다.
    if (password_verify($pwk, $dbPw)) //DB 패스워드와 입력한 패스워드를 검증합니다.
    {

        ?>
        <script type="text/javascript">location.replace("read.php?idx=<?php echo $board["idx"]; ?>");</script><!-- pwk와 bpw값이 같으면 read.php로 보내고 -->
        <?php
    } else { ?>
        
        <script type="text/javascript">alert('비밀번호가 틀립니다');</script><!--- 아니면 비밀번호가 틀리다는 메시지를 보여줍니다 -->
    <?php }
} ?>