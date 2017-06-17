#!/usr/bin/env bash
git tag
read -p "Please Set Tag Version " GIT_VERSION
git tag v$GIT_VERSION
git push origin v$GIT_VERSION
