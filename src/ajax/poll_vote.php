<?php
$vote = $_REQUEST['vote'];

//get content of textfile
$filename = "poll_result.txt";
$content = file($filename);

//put content in array
$array = explode("||", $content[0]);
$yes = $array[0];
$no = $array[1];

if ($vote == 0) {
    $yes = $yes + 1;
}
if ($vote == 1) {
    $no = $no + 1;
}

//insert votes to txt file
$insertvote = $yes . "||" . $no;
$fp = fopen($filename, "w");
fputs($fp, $insertvote);
fclose($fp);
?>
<div class="callout-header">Quick survey</div>
<span class="closebtn" onclick="this.parentElement.style.display='none';">ⓧ</span>
<div class="callout-container">
    <table>
        <tr>
            <td>Result:</td>
        </tr>
        <tr>
            <td> Love it 👍:</td>
            <td><img src="\RetroRecords/src/ajax/poll_img.jpg" width='<?php echo (100 * round($yes / ($no + $yes), 2)); ?>' height='20'>
                <?php echo (100 * round($yes / ($no + $yes), 2)); ?>%
            </td>
        </tr>
        <tr>
            <td> Hate it 👎:</td>
            <td><img src="\RetroRecords/src/ajax/poll_img.jpg" width='<?php echo (100 * round($no / ($no + $yes), 2)); ?>' height='20'>
                <?php echo (100 * round($no / ($no + $yes), 2)); ?>%
            </td>
        </tr>
    </table>
    <h3>Thank you for your time</h3>
</div>