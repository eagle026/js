<?php
$cid=$_GET['cid'];
$url=str_replace("\\","/",dirname(dirname(dirname(__FILE__))));
$contentTitle=array(
    'method'=>'回复方式 :',
    'type'=>'留言对象 :',
    'names'=>'姓名 :',
    'email'=>'<font color="red">*</font>E-mail :',
    'phone'=>'<font color="red">*</font>电话 :',
    'qq'=>'QQ :',
    'companys'=>'单位 :',
    'contents'=>'<font color="red">*</font>留言内容 :',
    'code'=>'验证码 :',
);
$contentHtml=array(
    'method'=>'<input type="radio" name="content[method]" value="1"/>网站<input type="radio" name="content[method]" value="2" checked/>邮箱<input type="radio" name="content[method]" value="3"/>短信',
    'type'=>'<select name="content[type]"><option value="1">个人</option><option value="2">公司</option></select>',
    'names'=>'<input type="text" name="content[names]" />',
    'email'=>'<input type="text" name="content[email]" id="email" dataType="Email" msg="信箱格式不正确"/>',
    'phone'=>'<input type="text" name="content[phone]" id="phone" />',
    'qq'=>'<input type="text" name="content[qq]" />',
    'companys'=>'<input type="text" name="content[companys]" dataType="Require" msg="单位不能为空"/>',
    'contents'=>'<textarea rows="3" cols="20" name="content[contents]" id="contents"></textarea>',
    'code'=>'<input type="text" name="code"  id="checkCap"/><img src="checkCap.php?action=get" id="captcha"/><span id="result"></span>',
);
$contentKey=array(  'method', 'type', 'names', 'email', 'phone', 'qq', 'companys', 'contents',/*'code'*/);
?>
<!DOCTYPE HTML>
<html lang="CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge; chrome=1">
    <title>橙客服系统</title>
    <link href="message.css" rel="stylesheet" type="text/css" />
    <script src="../lib/jquery-1.10.1.min.js"></script>
    <script src="../lib/validator-yuanban.js"></script>
</head>
<body>
<form action="" method="post" name="myform"  enctype="multipart/form-data" id="myform" >
    <input type="hidden" name="oneRoot" value="<?=$url ?>"/>
    <input type="hidden" name="cid" value="<?=$cid ?>"/>

    <div class="headerTitle" >您好，现在客服不在线，请留言，如果没有留下您的联系方式，客服将无法和您联系！</div>
    <?php foreach($contentKey as $v){?>
        <div class="parents">
            <div  class="first"><span class="title"><?=$contentTitle[$v]?></span></div>
            <div  class="second"><span class="<?=$v?>"><?=$contentHtml[$v]?></span></div>
        </div>
    <?php }?>
    <div style="clear: both"></div>
    <div class="btn">
       <a href="javascript:void(0)"  class="botton" name="submit" onclick="check_all();return false">提交留言</a>
      <!--  <button type="submit">登录</button>-->
    </div>

</form>
<script>
    var flag=2;
    $("#captcha").click(function(){
        $(this).attr("src","checkCap.php?action=get&t"+Math.random());
        flag=2;
    });
    $("#checkCap").blur(function(){
        $.ajax({
            type: "get",
            url: "checkCap.php",
            data: {"action":"check","code":$(this).val()},
            success: function(msg){
                if(msg==500){
                    var error="<font color=red>验证码错误</font>";
                    $("#result").html(error);
                    setTimeout(function(){ $("#result").html("")},3000);
                    flag=2;
                }else{
                    flag=1;
                }

            }
        });
    });
    function check_all(){
        var email=document.getElementById("email");
        var phone=document.getElementById("phone");
        var contents=document.getElementById("contents");
        var pattern1=/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/;
        var pattern2=/0?(13|14|15|18)[0-9]{9}/;
        var pattern3=/[0-9-()（）]{7,18}/;
/*        if(!pattern1.test(email.value)){
            alert("邮箱不合法");
            email.focus();
            return false;
        }
        if(!pattern2.test(phone.value)||!pattern3.test(phone.value)){
            alert("电话不合法");
            phone.focus();
            return false;
        }
        if(contents.value==''){
            alert("留言内容不能为空");
            contents.focus();
            return false;
        }*/
       var re= Validator.Validate($("#myform")[0],3);
       console.log(re);
     /*  /!* if(flag==1)*!/ myform.submit();*/

    }
</script>
</body>
