const http = require('http');
const exppress = require('express');
//create exppress obj
const app = exppress();


//les-2-forEach
console.log('--------------------les-2-forEach----------------');
myList = [1, 2, 3, 4, 5, 6];
myList.forEach(function (value) {
    console.log(value);
});


var postHTML = '<!DOCTYPE html><html><head><title>personal</title></head><body>' +
    '<h1>hi your</h1>' +
    '<form method="post" action="/"> ' +
    'email:<input type="email" name="eml"><br> ' +
    'name:<input type="text" name="name"><br>' +
    '<input type="submit" ></form>' +
    '</body></html>';
var qs = require(`querystring`);

var myhttp = http.createServer(function (request, response) {
    // response.writeHead(200);
    // response.write(/*JSON.stringify(info)*/postHTML);
    // response.end(postHTML);
    if (request.method == "POST") {
        var body = "";
        request.on('data', function (data) {
            body = body + data;
        });
        request.on('end', function () {
            var post = qs.parse(body);
            // console.log(post['eml']+post.eml);
            //console.log(JSON.stringify(post));
            response.end(JSON.stringify(post));
        });
    } else
        response.end(postHTML);
    // var querystring=url.parse(request.url,true).query;
    // console.log(querystring);
});
myhttp.listen(8888);
console.log("we listen to http http://localhost:8888?id=9&name=amro");


