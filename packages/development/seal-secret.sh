#!/usr/bin/env bash

kubeseal --controller-namespace kube-system \
    --controller-name sealed-secrets-sealed-secrets-controller \
    --format yaml \
    < secret.yaml > sealed-secret.yaml

kubeseal --controller-namespace kube-system \
    --controller-name sealed-secrets-sealed-secrets-controller \
    --format yaml \
    < github-credentials.yaml > github-credentails-sealed-secret.yaml
