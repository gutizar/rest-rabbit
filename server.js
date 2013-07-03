
// var context = require('rabbit.js').createContext('amqp://localhost:5672');

// context.on('ready', function() {
//   console.log('Connection to the server ready');
//   var sub = context.socket('SUB');
  
//   sub.connect('request_book', function() {
//     console.log('Connected to the Exchange');
//   });

//   sub.on('data', function(note) { 
//     console.log("Alarm! " + note); 
//   });
// });

// var io = require('socket.io').listen(9090);

// io.sockets.on('connection', function (socket) {
//   socket.emit('news', { hello: 'world' });
// });

var amqp = require('amqp');
var io = require('socket.io').listen(9090);

var connection = amqp.createConnection(
  { url: "amqp://guest:guest@localhost:5672" }, 
  { defaultExchangeName: "request-book" }
);

io.sockets.on('connection', function() {
  console.log('socket.io connected');
});

// Wait for connection to become established.
connection.on('ready', function () {
  console.log('Connection ready');
  
  // Use the default 'amq.topic' exchange  
  connection.queue(
    'request-book',
    {durable: true, autoDelete: false} ,
    function(q) {
      console.log('Connected to the request_book queue')
      // Catch all messages
      q.bind("request-book");

      // Receive messages
      q.subscribe(function (message) {
        // Print messages to stdout
        console.log('Received message');
        io.sockets.emit('queue', message);
      });
  });
});

connection.on('close', function () {
  console.log('Connection closed!');
})