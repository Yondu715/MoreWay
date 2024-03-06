FROM mysql:8.3

COPY ./*.cnf /etc/mysql/conf.d/
ADD ./*.sh /opt/pub/
RUN ["chmod", "664", "/etc/mysql/conf.d/custom.cnf"]

CMD ["mysqld"]