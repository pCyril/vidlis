DOCKER_COMPOSE_FILE=docker-compose.yml
DOCKER_IMAGE=tools
DEFAULT_ALLREADY_PASS=1
STOP_ON_FAILURE?=false
STANDALONE?=false
VOLUME?=false
OVERRIDE?=true
APP_VERSION?=vX.Y.Z
DOCKER_COMPOSE_RUN=$(shell echo 'docker-compose -f $(DOCKER_COMPOSE_FILE)' && if [ $(VOLUME) = true ]; then echo ' -f docker-compose-volume.yml' ; fi && if [ $(OVERRIDE) = true ]; then echo ' -f docker-compose.override.yml' ; fi && echo ' run --rm')
DOCKER_TAG?=latest

clear:
	@$(DOCKER_COMPOSE_RUN) $(DOCKER_IMAGE) /bin/sh -c 'cd /data/backend ; \
		rm var/cache/* -rf; rm var/logs/* -rf' || if [ $(STOP_ON_FAILURE) = true ]; then exit 1 ; fi

stop_on_failure:
	$(eval STOP_ON_FAILURE=true)

composer_install:
	@$(DOCKER_COMPOSE_RUN) tools composer install --prefer-dist --no-interaction || if [ $(STOP_ON_FAILURE) = true ]; then exit 1 ; fi

bash:
	$(eval COMMAND := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS)))
	$(eval COMMAND=$(shell echo $(COMMAND) | cut -f 1 -d ' '))
	@/bin/sh -c '$$(exit $(DEFAULT_ALLREADY_PASS)) || /bin/sh -c "if [ -z $(COMMAND) ]; then exit 1; fi"  && (($(DOCKER_COMPOSE_RUN) $(COMMAND) /bin/sh -c "/bin/bash") || (echo "Please use one of following" ; grep -v "^ " $(DOCKER_COMPOSE_FILE) | grep : | tr : " ") ; exit 0) || $(DOCKER_COMPOSE_RUN) $(DOCKER_IMAGE) /bin/sh -c "/bin/bash"' || exit 0
	$(eval DEFAULT_ALLREADY_PASS=0)
