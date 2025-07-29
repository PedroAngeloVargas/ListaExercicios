FROM golang:tip-alpine AS deploy

WORKDIR /app

COPY . .

RUN apk update && apk upgrade

RUN go mod download

RUN go build -o main

FROM alpine:latest

EXPOSE 8080

COPY --from=deploy /app/main /main

RUN addgroup -S ops && adduser -S -G ops pedro

RUN chown -R pedro:ops /main

USER pedro

CMD ["/main"]




