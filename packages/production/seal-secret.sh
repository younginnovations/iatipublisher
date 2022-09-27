#!/usr/bin/env bash

cat secret.yaml | kubeseal --controller-namespace kube-system \
    --controller-name sealed-secrets-sealed-secrets-controller \
    --format yaml \
    > sealed-secret.yaml

cat github-credentials.yaml | kubeseal --controller-namespace kube-system \
    --controller-name sealed-secrets-sealed-secrets-controller \
    --format yaml \
    > github-credentails-sealed-secret.yaml
