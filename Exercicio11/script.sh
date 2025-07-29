#!/bin/bash

/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)" 

eval "$(/home/linuxbrew/.linuxbrew/bin/brew shellenv)" 

brew install gcc 

brew install trivy 

trivy image python:3.9 
