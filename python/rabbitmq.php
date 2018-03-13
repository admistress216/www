<?php
$str = <<<Test
//send.py(queue方式)
#!/usr/bin/env python
import pika
import sys

connection = pika.BlockingConnection(pika.ConnectionParameters(
               host='127.0.0.1'))
channel = connection.channel()
channel.queue_declare(queue='task_queue', durable=True) #queue durable

message = ' '.join(sys.argv[1:]) or "Hello World!"
channel.basic_publish(exchange='',
                      routing_key='task_queue',
                      body=message,
                      properties=pika.BasicProperties(
                        delivery_mode = 2, # make message persistent/message durable
                      ))
print " [x] Sent %s" % (message,)
connection.close()

//send.py(exchange方式)
#!/usr/bin/env python
import pika
import sys

connection = pika.BlockingConnection(pika.ConnectionParameters(
        host='localhost'))
channel = connection.channel()

channel.exchange_declare(exchange='logs',
                         exchange_type='fanout')

message = ' '.join(sys.argv[1:]) or "info: Hello World!"
channel.basic_publish(exchange='logs',
                      routing_key='',
                      body=message)
print " [x] Sent %r" % (message,)
connection.close()

//receive.py(queue方式)
#!/usr/bin/env python
import pika
import time

connection = pika.BlockingConnection(pika.ConnectionParameters(
    host='localhost')) #1.build tcp
channel = connection.channel() #2.buildchannel

channel.queue_declare(queue='task_queue', durable=True) #3.build queue

#4.build message subscribe
print '[*]Waiting for message...'

def callback(ch, method, properties, body):
    print "[x]Received %r" % (body,)
    time.sleep(body.count('.')) #logic
    print "[x]Done"
    ch.basic_ack(delivery_tag = method.delivery_tag)

channel.basic_consume(callback, queue='task_queue', no_ack=False) #round-robin,acknowledgment default

channel.start_consuming()

//receive.py(exchange方式)
#!/usr/bin/env python
import pika

connection = pika.BlockingConnection(pika.ConnectionParameters(
        host='localhost'))
channel = connection.channel()

channel.exchange_declare(exchange='logs',
                         exchange_type='fanout')

result = channel.queue_declare(exclusive=True) #consumer close => queue close
queue_name = result.method.queue

channel.queue_bind(exchange='logs',
                   queue=queue_name) #bindling queue and exchange

print ' [*] Waiting for logs. To exit press CTRL+C'

def callback(ch, method, properties, body):
    print " [x] %r" % (body,)

channel.basic_consume(callback,
                      queue=queue_name,
                      no_ack=True)

channel.start_consuming()
Test;
