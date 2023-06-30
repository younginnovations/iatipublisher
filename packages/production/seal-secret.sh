#!/usr/bin/env bash

kubeseal --cert https://iatipublisher.yipl.com.np/v1/cert.pem \
    --format yaml \
    < secret.yaml > sealed-secret.yaml
