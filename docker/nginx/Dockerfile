FROM nginx:1.25.3 AS base

COPY ./nginx.conf /etc/nginx/nginx.conf
RUN chmod +x /etc/nginx/nginx.conf

COPY ./default.conf.template /etc/nginx/templates/

COPY ./custom /etc/nginx/custom

ARG WEB_USER_ID=${WEB_USER_ID}
ARG WEB_USER_NAME=${WEB_USER_NAME}
ARG WEB_GROUP_ID=${WEB_GROUP_ID}
ARG WEB_GROUP_NAME=${WEB_GROUP_NAME}
RUN echo "Building for web user: id=${WEB_USER_ID} name=${WEB_USER_NAME} group=${WEB_GROUP_NAME}"
RUN groupadd -g ${WEB_GROUP_ID} ${WEB_GROUP_NAME}|| echo "Group exists"
RUN useradd -m -u ${WEB_USER_ID} ${WEB_USER_NAME} -g ${WEB_GROUP_NAME} || echo "Users exists"
RUN sed -i -- "s/user  nginx;/user ${WEB_USER_NAME};/" /etc/nginx/nginx.conf
