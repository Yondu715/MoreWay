FROM rabbitmq:3.13.1-management

COPY ./rabbitmq.conf /etc/rabbitmq/

RUN chown -R rabbitmq:rabbitmq /var/lib/rabbitmq
RUN chmod 770 /var/lib/rabbitmq

USER root

CMD ["rabbitmq-server"]

