
var amqp = require('amqp');
var io = require('socket.io').listen(9090);

var connection = amqp.createConnection(
  { url: "amqp://guest:guest@localhost:5672" },
  { defaultExchangeName: "chat" }
);

io.sockets.on('connection', function () {
  console.log('socket.io connected');
});

// Wait for connection to become established.
connection.on('ready', function () {
  console.log('Connection ready');
  // Use the default 'amq.topic' exchange  
  connection.queue(
    'chat',
    {durable: true, autoDelete: false},
    function (q) {
      console.log('Connected to the chat queue');
      // Catch all messages
      q.bind("chat");

      // Receive messages
      q.subscribe(function (message) {
        // Print messages to stdout
        console.log('Received message');
        io.sockets.emit(message.chatId, message);
      });
    }
  );
});

connection.on('close', function () {
  console.log('Connection closed!');
});