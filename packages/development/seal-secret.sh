#!/usr/bin/env bash

kubeseal --cert https://sealed-secrets.k8s.yipl.com.np/v1/cert.pem \
    --format yaml \
    < secret.yaml > sealed-secret.yaml
