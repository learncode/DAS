<?php
$residue = md5('hello');

echo 'Word: hello'.'. Residue: '.$residue.'. Length: '.strlen($residue).'<br/>';

$residue = md5("The quick brown fox jumps over the lazy dog");
echo $residue.' - '.strlen($residue).'<br/>';

$sha1 = sha1('The quick brown fox jumps over the lazy dog');
echo 'sha1'.'<br/>';
echo $sha1.' - '.strlen($sha1).'<br/>';