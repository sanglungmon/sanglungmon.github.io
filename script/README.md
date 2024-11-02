## 📖: ติดตั้ง Slowdns
```bash
wget https://raw.githubusercontent.com/sanglungmon/hunmai/main/slowdns.sh
chmod +x slowdns.sh
./slowdns.sh
```
## 📖: แสดงคนออนไลน์
```bash
wget https://raw.githubusercontent.com/sanglungmon/hunmai/main/online.sh
chmod +x online.sh
./online.sh
```
## 📖: เปลี่ยนพอร์ต ออนไลน์
```bash
sudo nano /etc/apache2/ports.conf
```
## 📖: รีพอร์ต
```bash
sudo systemctl restart apache2
```
## 📖: รีบูตออโต้
```bash
echo "30 3 * * * root /sbin/reboot" > /etc/cron.d/reboot
service cron restart
```
## 📖: เช็ครีบูต
```bash
nano /etc/cron.d/reboot
```
## 📖: เปลี่ยนพอร์ตovpn
```bash
sudo nano /etc/apache2/ports.conf
```
## 📖: เปลี่ยนพอร์ต ssl
```bash
nano /etc/stunnel/stunnel.conf
```
## 📖: รีพอร์ต
```bash
sudo systemctl restart apache2
```
## 📖: เปลี่ยจำนวนคนออนไลน์
```bash
nano /usr/local/bin/count_online_users.sh
```
