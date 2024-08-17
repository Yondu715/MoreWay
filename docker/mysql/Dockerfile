FROM mysql:8.3

COPY ./*.cnf /etc/mysql/conf.d/
RUN ["chmod", "664", "/etc/mysql/conf.d/custom.cnf"]

CMD ["mysqld"]