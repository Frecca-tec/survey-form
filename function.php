<?php
  function h($str){
    // htmlspecialchars は、HTMLタグをエスケープする関数
    // これにより、ユーザーが入力した内容がHTMLとして解釈されるのを防ぐ
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
?>