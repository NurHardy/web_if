<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>
        <title>Jurusan Ilmu Komputer/Informatika Universitas Diponegoro</title>
        <link>http://project.nurhardyanto.web.id/</link>
        <description>Berita terbaru website jurusan Ilmu Komputer/Informatika UNDIP</description>
        <language>in</language>
        <copyright>Copyright (C) 2014 Informatika UNDIP</copyright>
<?php
	foreach($_posts as $_post) {
		echo "\t\t<item>\n";
		echo "\t\t\t<title>{$_post->judul}</title>\n";
		echo "\t\t\t<description>";
		echo htmlentities(substr(strip_tags($_post->isi_berita),0,310)) . "...";
		echo "</description>\n";
		echo "\t\t\t<link>http://project.nurhardyanto.web.id/news/{$_post->id_berita}/</link>\n";
		echo "\t\t\t<pubDate>".date("D, d M Y H:i:s O", strtotime($_post->tanggal))."</pubDate>\n";
		echo "\t\t</item>\n";
	}
?>		</channel>
</rss>