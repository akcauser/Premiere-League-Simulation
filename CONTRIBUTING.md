# Contributing Guide

1. Fork the project
2. Create your feature branch (`git checkout -b new-feature-branch`)
3. Commit your changes (`git commit -m "new commit message"`)
4. Push to the branch (`git push -u origin new-feature-branch`)
5. Open a Pull Request

# Development Details

### Docker Rebuild
Rebuild docker containers when you change anything.

1. Run build command in project root directory

```shell
docker-compose build
```

2. Start containers again

```shell
docker-compose up -d 
```
