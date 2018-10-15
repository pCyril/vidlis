FROM nginx:stable

RUN echo "Europe/Paris" > /etc/timezone && \
 dpkg-reconfigure --frontend noninteractive tzdata

COPY ./docker/nginx/config/nginx.conf /etc/nginx/

COPY ./frontend/dist /data/frontend/dist
COPY ./backend/web/app.php /data/backend/web/app.php
