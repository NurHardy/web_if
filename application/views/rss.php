<?php
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<rss version=\"2.0\">\n";
echo "\t<channel>\n";
echo "\t\t<title>Jurusan Ilmu Komputer/Informatika Universitas Diponegoro</title>\n";
echo "\t\t<link>".base_url()."</link>\n";
echo "\t\t<description>Berita terbaru website jurusan Ilmu Komputer/Informatika UNDIP</description>\n";
echo "\t\t<language>in</language>\n";
echo "\t\t<copyright>Copyright (C) 2014 Informatika UNDIP</copyright>\n";
foreach($_posts as $_post) {
	echo "\t\t<item>\n";
	echo "\t\t\t<title>{$_post->judul}</title>\n";
	echo "\t\t\t<description>";
	echo htmlentities(substr(strip_tags($_post->isi_berita),0,310)) . "...";
	echo "</description>\n";
	echo "\t\t\t<link>".htmlentities(base_url("/news/".$_post->id_berita))."/</link>\n";
	echo "\t\t\t<pubDate>".date("D, d M Y H:i:s O", strtotime($_post->tanggal))."</pubDate>\n";
	echo "\t\t</item>\n";
}
echo "\t</channel>\n";
echo "</rss>\n";
