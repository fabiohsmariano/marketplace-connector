start:
	cp .env.example .env
	chmod -R 777 .env
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail artisan horizon

start-mock:
	docker run -d --mount type=bind,source=./mocketplace.json,target=/data,readonly -p 3000:3000 mockoon/cli:latest -d /data -p 3000

kill:
	./vendor/bin/sail down
