SPUD and VIS in a MP running batman-adv
=======================================

SPUD was originally written to interface with the VIS server (L3 batman) 
that is included in our customized Nano Station Image:
http://villagetelco.org/download/firmware/vt/stable/ns2/

Steve has written these notes for those that want to run VIS in
a mesh potato (MP). The notes apply to VIS running in batman-adv mode (L2)

1) Install xinetd

You can download the xinetd package for the Mesh Potato from

http://villagetelco.org/download/firmware/secn/unstable/mp/packages/xinetd_2.3.14-1_mips.ipk

If your Mesh Potato is on the Internet, you could simply use wget to
pull it down to the MP or you could download it to your computer and
scp it to the MP.   In either case, put it in the /tmp directory.
Then log into the Mesh Potato, change to the /tmp directory and
execute the following command:

root@OpenWrt:~#cd /tmp
root@OpenWrt:~#opkg install xinetd_2.3.14-1_mips.ipk

2.  Create file:  /etc/xinetd.d/vis

root@OpenWrt:~#vi /etc/xinetd.d/vis

and insert the following text:
----------------------
       # default: on
       # description: Vis socket server
       service vis
        {
		port            = 2005
   		socket_type     = stream
   		wait            = no
   		user            = root
   		server          = /etc/vis.sh
   		log_on_success  += USERID
   		log_on_failure  += USERID
   		disable         = no
         }
-----------------------

Make xinetd start on boot

root@OpenWrt:~# cd /etc/rc.d
root@OpenWrt:~# ln -s ../init.d/xinetd S93xinetd
root@OpenWrt:~# /etc/init.d/xinetd

3. Create vis.sh

root@OpenWrt:~#vi /etc/vis.sh

-----------------------
    #!/bin/sh
    batctl vd json
-----------------------

Make it executable

root@OpenWrt:~#chmod +x /etc/vis.sh

4.  Edit /etc/services

root@OpenWrt:~#vi /etc/services

 and add the line:

-----------------------
vis           2005/tcp     # Vis server
-----------------------

5.  Enable the VIS server with the command

root@OpenWrt:~# batctl vm server


6. Map MAC addresses to IP addresses

Create file /etc/bat-hosts

root@OpenWrt:~#vi /etc/bat-hosts


==
Configure SPUD with the following parameters
port 2005
vis_version trunk
mode batman-adv
