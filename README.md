AWS EC2 Wrapper for PHP
========================

This package aims to wrap around Amazons PHP sdk so that it provides the developer with a more object-orientated interface. Thus the developer will spend less time looking up the parameters they can pass into an array.
This version of the wrapper is based on [version 3 of the SDK](https://docs.aws.amazon.com/aws-sdk-php/v3/api/).

## Debugging
I've occasionally had issues with running commands that would just block and never return. The solution for me was to install the php-xml package with

```
sudo apt-get install php-xml
```

I will remove this note once I have figured out how to make composer require that for installation.
