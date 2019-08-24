ls $1 | grep -i .mp4 | sort > test
for i in $(cat test)
do
	name=$(echo $i | rev | cut -f 2- -d '.' | rev)
 ffmpeg  -i "$1$i" -loglevel verbose -threads 3 -f hls -hls_time 60 -hls_list_size 99999  -start_number 1 -t 9000 -strict -2 -hls_segment_filename  "/opt/lampp/htdocs/video/uploads/$name"%01d.ts "/opt/lampp/htdocs/video/uploads/live/$name".m3u8
done 
