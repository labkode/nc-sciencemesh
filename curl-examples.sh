#!/bin/bash
echo
echo Create a folder called 'creation'
curl -v -H'Content-Type: application/json' -d'{"path":"/creation"}' http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/CreateDir
echo
echo
echo
echo You should see it on the local filesystem:
ls -la ../../data/einstein/files/sciencemesh
echo
echo
echo And doing a GetMD:
curl -v -H'Content-Type: application/json' -d'{"path":"/creation"}' http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/GetMD
echo
echo
echo
echo Now remove it:
rmdir ../../data/einstein/files/sciencemesh/creation/
echo
echo
echo You should see a 404:
curl -v -H'Content-Type: application/json' -d'{"ref":{"path":"/creation"}}' http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/GetMD
echo
echo
echo
echo It should be gone from the local filesystem too:
ls -la ../../data/einstein/files/sciencemesh/
echo
echo
echo GetMD for Einstein's sciencemesh \(home\) folder:
curl -v -H'Content-Type: application/json' -d'{"ref":{"path":"/"}}' http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/GetMD
echo
echo
echo
echo Delete Einstein's sciencemesh \(home\) folder:
rm -rf /Users/michiel/gh/nextcloud/server/data/einstein/files/sciencemesh/
echo
echo
echo You should see a 404
curl -v -H'Content-Type: application/json' -d'{"ref":{"path":"/"}}' http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/GetMD
echo
echo
echo
echo CreateHome request:
curl -v -H'Content-Type: application/json' -X POST http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/CreateHome
echo
echo
echo
echo A sciencemesh folder should exist now:
ls -la /Users/michiel/gh/nextcloud/server/data/einstein/files/
echo
echo
echo And its GetMD:
curl -v -H'Content-Type: application/json' -d'{"ref":{"path":"/"}}' http://einstein:relativity@localhost:8080/index.php/apps/sciencemesh/~einstein/api/storage/GetMD
echo
