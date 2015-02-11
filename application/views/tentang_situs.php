<style>
	#foto_develop {
		display: block;
		max-width: 450px;
		width: 90%;
		position: relative; 
		margin: auto;
	}
	/* size and position red boxes */
  div.item { width: 64px; height: 64px; position: absolute; overflow: visible}
/* show red outline and slight grey fill on hover */
  div.item:hover { 
    display: block; 	
    border: 1px solid #fff;
    background: none;    /* the fallback if no rgba */
    background: rgba(255, 255, 255, 0.3);
  }
/* hide the a until hover */
  div.item .tagn { display: none; } 
/* make the area of the a tag fill the div */
  div#foto_develop .tagn {
    width: 100%;
    height: auto;
    padding-top: 80px;
	text-align: center;
  }
 
  div#foto_develop .item:hover .tagn{
    position: absolute;  
    width: 120px;
    /* height: 60px; */
    display: block; 
    font-size: 12px; 
    line-height: 1.4em;
    background: #fff;
    color:#000;
    /*border: 1px solid #000; */
    padding: 5px;
	left: -32px; 
    top: 64px;
  }
  div#foto_develop .tagn a {
		text-decoration: none;
		color:#00f;
		display: block;
  }
</style>
<div id='site_content_article'>
	<h2><?php echo $page_title?></h2>
	<hr>
	<h3>Penerbit</h3>
	<p>	
		<b>Website ini diterbitkan oleh :</b><br>
		Jurusan Ilmu Komputer / Informatika<br>
		Universitas Diponegoro
	</p>
	<hr>
	<div class='divclear'></div>
	<h3>Pengembang dan Pendukung</h3>
	<div id='foto_develop' title='DIGIT Team'/>
		<img style='max-width:650px;height:auto;width:100%;border:solid #C4B8B8 3px;box-shadow: 0px 0px 4px rgba(0,0,0,0.3)' src="http://if.undip.ac.id/v1/assets/media/m04032014_Digit_Team.jpg"/>
		<div class="item" style="top: 61px; left: 41px;"><div class="tagn">Muh. Nur Hardyanto</div></div>
		<div class="item" style="top: 83px; left: 126px;"><div class="tagn">Muh. Sofi Yuniarto</div></div>
		<div class="item" style="top: 87px; left: 179px;"><div class="tagn">Adik Istanto</div></div>
		<div class="item" style="top: 98px; left: 245px;"><div class="tagn">Eko Wahyudi</div></div>
		<div class="item" style="top: 96px; left: 304px;"><div class="tagn">Wildan Azka</div></div>
		<div class="item" style="top: 87px; left: 353px;"><div class="tagn">Moh. Fajar Ainul</div></div>
	</div>
	<div class='divclear'></div>
	<div id='site_develop'>
	<h3>Pengembang</h3>
	<hr>
	<p>Secara terbuka kami menerima kritik dan saran untuk website yang lebih baik.</p>
	<table cellpadding='5px'>
		<tr><td valign='top' width='300px'><strong>Muhammad Nur Hardyanto</strong><br><a href='mailto:nurhardyanto@if.undip.ac.id'>nurhardyanto@if.undip.ac.id</a></td></tr>
		<tr><td valign='top' width='300px'><strong>Adik Istanto</strong><br><a href='mailto:adikistanto1@gmail.com'>adikistanto1@gmail.com</a></td></tr>
		<tr><td valign='top' width='300px'><strong>Eko Wahyudi</strong><br><a href='mailto:wahyudi_eko@if.undip.ac.id'>wahyudi_eko@if.undip.ac.id</a></td></tr>
	</table>
	</div>
	<div id='site_support'>
	<h3>Pendukung</h3>
	<hr>
	<p>Terima kasih juga kepada rekan-rekan yang telah membantu dalam proses pengembangan:</p>
	<table cellpadding='5px'>
		<tr><td valign='top' width='300px'><strong>Mohammad Fajar Ainul Bashri</strong><br><a href='mailto:fajarainul14@gmail.com'>fajarainul14@gmail.com</a></td></tr>
		<tr><td valign='top' width='300px'><strong>Muhammad Sofi Yuniarto</strong><br><a href='mailto:msyuniarto@gmail.com'>msyuniarto@gmail.com</a></td></tr>
		<tr><td valign='top' width='300px'><strong>Wildan Azka Adzani</strong><br><a href='mailto:wildanazkax5@yahoo.com'>wildanazkax5@yahoo.com</a></td></tr>
	</table>
	</div>
	<div class='divclear'></div>
	<hr>
	<h3>Site Credits</h3>
	Website ini dikembangkan dengan menggunakan framework <a href='http://ellislab.com/codeigniter'>Codeigniter</a> v.2. dan komponen-komponen berikut:
	<ul>
		<li><a href='http://jquery.com'>jQuery JavaScript Library v1.6.2</a></li>
		<li><a href='http://malsup.com/jquery/form/'>jQuery form plugin</a></li>
		<li><a href='http://www.pixedelic.com/plugins/diapo/'>Diapo slider</a></li>
		<li><a href='http://www.apycom.com/'>Apycom Menu</a></li>
		<li><a href='http://www.geekchamp.com/icon-explorer/'>GeekChamp.com Icon Collection</a></li>
	</ul>
	<hr>
	<p> Kontribusi berita ke website Informatika disalurkan melalui email: <a href='mailto:if@undip.ac.id'>if@undip.ac.id</a></p>
	<hr>
</div>