
<!-- Highlight number markers -->
<?php
if ($searchcave<10) {
  $mleft = -7;
  $mtop = -3;
  $msize = 20;
} else {
  $mleft = -4;
  $mtop = -4;
  $msize = 22;
}
if ($default_cave_ID != '0' && strlen($searchcave)>0) {
  echo '<a href="'.$url.$searchcave.'&plan_floor=1" id="c'.$searchcave.'">
        <img src="http://elloracaves.org/images/decor/marker_number_on_20px.png" id="marker_number"
             border="0" width="'.$msize.'" height="'.$msize.'" style="position:absolute; left:'.$mleft.'px; top:'.$mtop.'px;" />
  </a>';
}

//<!-- Cave numbers on map -->
$url = 'http://elloracaves.org/caves.php?cmd=search&words=&image_ID=&cave_ID=';
$fontsmall = 'style="font-size:80%"';
//'style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;"';

echo '
<a href="'.$url.'1&plan_floor=1" id="c1">1</a>
<a href="'.$url.'2&plan_floor=1" id="c2">2</a>
<a href="'.$url.'3&plan_floor=1" id="c3">3</a>
<a href="'.$url.'4&plan_floor=1" id="c4">4</a>
<a href="'.$url.'5&plan_floor=1" id="c5">5</a>
<a href="'.$url.'6&plan_floor=1" id="c6">6</a>
<a href="'.$url.'7&plan_floor=1" id="c7">7</a>
<a href="'.$url.'8&plan_floor=1" id="c8">8</a>
<a href="'.$url.'9&plan_floor=1" id="c9">9</a>
<a href="'.$url.'10&plan_floor=1" id="c10">10</a>
<a href="'.$url.'11&plan_floor=1" id="c11">11</a>
<a href="'.$url.'12&plan_floor=1" id="c12">12</a>
<a href="'.$url.'13&plan_floor=1" id="c13">13</a>
<a href="'.$url.'14&plan_floor=1" id="c14">14</a>
<a href="'.$url.'15&plan_floor=1" id="c15">15</a>
<a href="'.$url.'16&plan_floor=1" id="c16"><font color="white">16</font></a>
<a href="'.$url.'1016&plan_floor=2" id="c1016">16L</a>
<a href="'.$url.'2016&plan_floor=1" id="c2016">16T</a>
<a href="'.$url.'3016&plan_floor=1" id="c3016">16ab</a>
<a href="'.$url.'4016&plan_floor=1" id="c4016">16s</a>
<a href="'.$url.'17&plan_floor=1" id="c17">17</a>
<a href="'.$url.'18&plan_floor=1" id="c18">18</a>
<a href="'.$url.'19&plan_floor=1" id="c19">19</a>
<a href="'.$url.'20&plan_floor=1" id="c20">20a</a>
<a href="'.$url.'120&plan_floor=1" id="c120">20b</a>
<a href="'.$url.'21&plan_floor=1" id="c21">21</a>
<a href="'.$url.'22&plan_floor=1" id="c22">22</a>
<a href="'.$url.'23&plan_floor=1" id="c23">23</a>
<a href="'.$url.'24&plan_floor=1" id="c24">24</a>
<a href="'.$url.'124&plan_floor=1" id="c124">24a1</a>
<a href="'.$url.'224&plan_floor=1" id="c224">24a2</a>
<a href="'.$url.'25&plan_floor=1" id="c25">25</a>
<a href="'.$url.'26&plan_floor=1" id="c26">26</a>
<a href="'.$url.'27&plan_floor=1" id="c27">27</a>
<a href="'.$url.'28&plan_floor=1" id="c28">28</a>
<a href="'.$url.'29&plan_floor=1" id="c29">29</a>
<a href="'.$url.'30&plan_floor=1" id="c30"><font color="white">30</font></a>
<a href="'.$url.'130&plan_floor=1" id="c130">30a</a>
<a href="'.$url.'31&plan_floor=1" id="c31">31</a>
<a href="'.$url.'32&plan_floor=1" id="c32">32</a>
<a href="'.$url.'132&plan_floor=1" id="c132">32y</a>
<a href="'.$url.'33&plan_floor=1" id="c33">33</a>
<a href="'.$url.'34&plan_floor=1" id="c34">34</a>
<a href="'.$url.'10001&plan_floor=1" id="c10001" '.$fontsmall.'>g1,2,3,4,5</a>
<a href="'.$url.'10006&plan_floor=1" id="c10006" '.$fontsmall.'>g6,7</a>
<a href="'.$url.'10008&plan_floor=1" id="c10008" '.$fontsmall.'>g8,9,10,11,12</a>
<a href="'.$url.'10013&plan_floor=1" id="c10013" '.$fontsmall.'>g13,14,15,16</a>
<a href="'.$url.'10017&plan_floor=1" id="c10017" '.$fontsmall.'>g17,18,19</a>
<a href="'.$url.'20001&plan_floor=1" id="c20001" '.$fontsmall.'>j1,2</a>
<a href="'.$url.'20003&plan_floor=1" id="c20003" '.$fontsmall.'>j3,4</a>
';
?>