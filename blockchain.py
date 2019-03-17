# Blockchain Pandora

'''
Listare API Pandora

User:
    http://127.0.0.1:port/user/set_receiver -> Seteaza un nou utilizator al acestei retelei.

Block:
    http://127.0.0.1:port/block/mine_block -> Mineaza un block nou pe care il adauga la retea.

    http://127.0.0.1:port/block/hash -> Cripteaza mesajul cu algoritmul SHA 512.

Wallet:
    http://127.0.0.1:port/wallet/new_wallet -> Genereaza un portofel nou.

Transactions:
    http://127.0.0.1:port/transactions/generate_transaction -> Genereaza o tranzactie noua.

    http://127.0.0.1:port/transactions/new_transactions -> Se valideaza tranzactia generata si se adauga in Mempool.

    http://127.0.0.1:port/transactions/get_transactions -> Se listeaza toate tranzactiile din Mempool.

Chain:
    http://127.0.0.1:port/chain/get_chain -> Se listeaza intreg lantul din acest nod.

    http://127.0.0.1:port/chain/is_valid -> Se verifica daca lantul este valid.

Nodes:
    http://127.0.0.1:port/nodes/get_nodes-> Se listeaza toate nodurile legate la asceasta retea.

    http://127.0.0.1:port/nodes/connect_nodes -> Se conecteaza nodurile la retea.
	
	http://127.0.0.1:port/nodes/register_node -> Inregistreaza un nod nou la retea

    http://127.0.0.1:port/nodes/remove_node/<node_url>-> Elimina un nod din retea.

    http://127.0.0.1:port/nodes/replace_chain -> Se inlocuieste lantul din nod cu cel mai lung din din noduri 




'''

#  TODO: 
# 1. Setez un beneficar nou pentru acest lant
# 2. Generez un portofel nou pentru utilizatorul retelei  

import os
import datetime
import hashlib 
import json
import Crypto
import Crypto.Random
import requests 
import binascii
import random
import mysql.connector as connector

from flask import Flask, jsonify, request 
from uuid import uuid4
from urllib.parse import urlparse
from Crypto.Hash import SHA
from Crypto.PublicKey import RSA
from Crypto.Signature import PKCS1_v1_5
from flask_cors import CORS

# Sectiunea 1 - Dezvoltarea retelei, crearea node-urilor si dezvoltarea tranzactiilor.


MINING_DIFFICULTY = '0000'


class Blockchain():
    
    def __init__(self):
        self.chain = []
        self.transactions = []
        self.chain_hashes = []

        genesis_block = self.create_block(proof = 1, previous_hash = '0')
        block_hash = self.proof_of_work(genesis_block)
        
        self.chain_hashes.append(block_hash[0])
        self.nodes = set()
        self.receiver = ''
        self.port = self.get_node_port()
        # self.node_address = str(uuid4()).replace('=','')
        self.node_address = "Pandora Blockchain"
        self.init_data()
       
    # Sincronizarea nodului curent cu intreaga retea
    def init_data(self):
        db = connector.connect(host="localhost",user="root",passwd="",database="blockchain_db")

        # Setez receiver-ul retelei din baza de date in functie de ce nod are
        self.init_receiver(db)

        # Setez lantul initial din baza de date 
        self.init_chain_from_db(db)

        db.close()

    def init_receiver(self,db):
        receiver_cursor = db.cursor()
        receiver_cursor.execute("SELECT user.username FROM node INNER JOIN user ON node.user_id=user.id WHERE node_address='127.0.0.1:{0}'".format(self.port)) 
        receiver_result = receiver_cursor.fetchone()
        self.receiver = receiver_result[0]

    def init_chain_from_db(self,db):
        block_cursor = db.cursor()
        block_cursor.execute("SELECT block.id, block.timestamp, block.proof_of_work, block.previous_hash,hash.hash,miner.username  FROM block INNER JOIN hash ON hash.block_id = block.id INNER JOIN user as miner ON  block.miner_id=miner.id")
        block_result = block_cursor.fetchall()

        if len(block_result) > 0:
            #self.chain["hashes"][0] = block_result[0][3]
            self.chain_hashes[0] = block_result[0][3]

            for block in block_result:
                self.chain_hashes.append(block[4])
                block_data  = {
                    "index": block[0]+1,
                    "timestamp": str(block[1]),
                    "proof": block[2],
                    "previous_hash": block[3]
                }
                
                transaction_cursor = db.cursor()
                transaction_cursor.execute("SELECT receiver_address, sender_address, amount FROM transaction WHERE block_id = {0}".format(block[0]))
                transaction_result = transaction_cursor.fetchall()
                transaction_list = []
                transactions_total = 0
                for transaction in transaction_result:
                    if transaction[2].is_integer():
                        amount = int(transaction[2])
                    else:
                        amount = float(transaction[2])
                    transaction_data = {
                        "amount": amount,
                        "receiver":transaction[0],
                        "sender":transaction[1]
                    }
                    transactions_total = transactions_total + amount
                    transaction_list.append(transaction_data)
                transaction_reward = {
                    "amount": transactions_total * 0.1,
                    "receiver":block[5],
                    "sender":self.node_address
                }
                transaction_list.append(transaction_reward)
                block_data['transactions'] = transaction_list
                self.chain.append(block_data)
            # self.chain['hashes'] = self.chain_hashes
            # self.chain['length'] = len(self.chain['chain'])

    def hash(self,message):
        encoded_message = json.dumps(message,sort_keys = True).encode()
        return  hashlib.sha512(encoded_message).hexdigest()

    def get_host(self):
        host = "http://127.0.0.1:{}".format(self.port)
        return host

    def get_node_port(self):
        try:
            base  = os.path.basename(__file__)
            port  = int(os.path.splitext(base)[0][-4:])
        except ValueError:
            port  = random.randint(5000,5999) # Daca nu este definit un port se genereaza unul aleator.
        return port

    def create_block(self,proof,previous_hash):
        block = {
                    'index' : len(self.chain) + 1,
                    'timestamp' : str(datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")),
                    'proof' : proof,
                    'previous_hash' : previous_hash,
                    'transactions': self.transactions,
                 }

        #golesc lista cu tranzactii dupa ce a fost minat blocul 
        self.transactions = []
        
        # adaug de fiecare data la lant inca un bloc.
        self.chain.append(block)
        
        return block
        
    def get_previous_block(self):
        return self.chain[-1]
    
    
    # Problema pe care o vor rezolva minerii in scopul obtinerii unui block nou.
    def proof_of_work(self,block):
        encoded_block = json.dumps(block,sort_keys = True).encode()
        new_proof = 1
        check_proof = False
        hash_operation = []
        
        #Se va incerca fiecare optiune pana minerul gaseste verificarea corecta.
        while check_proof is False:
            #hash_operation = hashlib.sha512(str(new_proof**2 - previous_proof**2).encode()).hexdigest()
            block_hash = hashlib.sha512(encoded_block + str(new_proof).encode()).hexdigest()
            if block_hash[0:4] == MINING_DIFFICULTY:
                check_proof = True
            else:
                new_proof = new_proof + 1
                check_proof = False
                
        hash_operation.append(block_hash)
        hash_operation.append(new_proof)
        return hash_operation
    
    
    # Verific fiecare nod daca are  previous_hash egal cu hash-ul blocului precedent si daca nonce-ul este corect minat.
    def is_chain_valid(self,chain):
        previous_block = chain[0]  
        #previous_proof = previous_block['proof']
        block_index    = 1
        
        while block_index < len(chain):
            block = chain[block_index]
            hash_operation = self.proof_of_work(previous_block)
            if block['previous_hash'] != hash_operation[0]:
                return False
            #proof = block['proof']
            hash_operation = self.proof_of_work(block)
            
            if hash_operation[0][0:4] != MINING_DIFFICULTY:
                return False
            previous_block = block 
            block_index = block_index + 1
        
        return True
    
    # Verific daca semnatura primita este corecta cu cea care s-a semnat tranzactia 
    def verify_transaction_signature(self, sender, signature, transaction):
        public_key = RSA.importKey(binascii.unhexlify(sender))
        verifier = PKCS1_v1_5.new(public_key)
        hash_operation = SHA.new(str(transaction).encode('utf8'))
        return verifier.verify(hash_operation, binascii.unhexlify(signature))

    # Adaug o tranzactie in Mempool
    def add_transaction(self,sender,receiver,amount,signature):
        transaction  = {
                        'amount': amount,
                        'receiver':receiver,
                        'sender':sender,
                       }

        if receiver  == self.receiver:
            self.transactions.append(transaction)
            previous_block = self.get_previous_block()
            return previous_block['index'] + 1
        else:
            transaction_verification = self.verify_transaction_signature(sender,signature,transaction)
            if transaction_verification is True:
                self.transactions.append(transaction)
                previous_block = self.get_previous_block()
                return previous_block['index'] + 1
            else:
                return False
    
    # Adaug un nou nod la retea(adica un utilizator nou care are acces la retea)
    def add_node(self,address):
            parsed_url = urlparse(address)
            if parsed_url.netloc:
                self.nodes.add(parsed_url.netloc)
            else:
                raise ValueError('Nod invalid.')
    
    # Elimina un nod din retea
    def remove_node(self, node):
        if node in self.nodes:
            self.nodes.discard(node)
            return True  
        else:
            return False

    # Inlocuiesc lantul cu cel mai lung lant din retea       
    def replace_chain(self):
        network =  self.nodes
        longest_chain = None
        max_length  = len(self.chain)
        for node in network:
            response = requests.get('http://{0}/chain/get_chain'.format(node))
            if response.status_code == 200:
                length = response.json()['length']
                chain = response.json()['chain']
                if length > max_length and self.is_chain_valid(chain):
                    max_length = length
                    longest_chain = chain
                    hashes = response.json()['hashes']
        if longest_chain:
            self.chain = longest_chain
            self.chain_hashes = hashes
            return True
        return False   

# Creez clasa cu tranzactiile pe care le genereaza un investitor/sau miner     
class Transaction:

    def __init__(self, sender, sender_private_key, receiver, amount):
        self.sender = sender
        self.sender_private_key = sender_private_key
        self.receiver = receiver
        self.amount = amount

    # Semnez tranzactia folosing cheia privata
    def sign_transaction(self):
        private_key = RSA.importKey(binascii.unhexlify(self.sender_private_key))
        signer = PKCS1_v1_5.new(private_key)
        transaction_hash = {
                            'amount':self.amount,
                            'receiver':self.receiver,
                            'sender':self.sender,
                           }
        hash_operation = SHA.new(str(transaction_hash).encode('utf8'))
        return binascii.hexlify(signer.sign(hash_operation)).decode('ascii')

# Sectiunea 2 - Minarea de blocuri

#Crearea aplicatiei web
        
app = Flask(__name__)
app.config['JSON_SORT_KEYS'] = False # Daca nu vreau sa sortez elementele , decomentez aceasta linie
CORS(app)

blockchain = Blockchain()

# Metoda de criptare folosita de retea
@app.route('/block/hash', methods=['POST'])

def hash():
    json = request.get_json()
    message = ['message']
    if not all (key in json for key in message):
        return 'A aparut o eroare la cheia beneficiarului.', 400
    message_hash =  blockchain.hash(json['message'])
    response = {
                'message_hash': message_hash
               }
    return jsonify(response), 200

# Crearea unui nou portofel pentru obtinearea chei private si publice
@app.route('/wallet/new_wallet', methods=['GET'])

def new_wallet():
	random_gen = Crypto.Random.new().read
	private_key = RSA.generate(1024, random_gen)
	public_key = private_key.publickey()
	response = {
		'private_key': binascii.hexlify(private_key.exportKey(format='DER')).decode('ascii'),
		'public_key': binascii.hexlify(public_key.exportKey(format='DER')).decode('ascii')
	}

	return jsonify(response), 200

#Setez beneficiarul acestui lant, va fi de asemenea si miner
@app.route('/user/set_receiver',methods=['POST'])

def set_receiver():
    json = request.get_json()
    receiver_keys =['receiver']
    if not all (key in json for key in receiver_keys):
        return 'A aparut o eroare la cheia beneficiarului.', 400
    blockchain.receiver = json['receiver']
    response = {
                'message':'Beneficiarul acestui lant este {0}'.format(blockchain.receiver) 
               }
    return jsonify(response), 201

# Minarea unui bloc nou si adaugarea tranzactiilor din Mempool la retea
@app.route('/block/mine_block',methods = ['GET'])

def mine_block():
    previous_block = blockchain.get_previous_block()
    #previous_proof = previous_block['proof']
    hash_operation = blockchain.proof_of_work(previous_block)

    transactions_total =  0
    for transaction in blockchain.transactions:
        transactions_total = transactions_total + transaction['amount']

    blockchain.add_transaction(sender = blockchain.node_address, receiver = blockchain.receiver, amount = transactions_total * 0.1 ,signature = '')
    previous_hash = hash_operation[0] # Iau hash-ul ultimului block 
    proof = hash_operation[1] # Iau dovada block-ului pe care il  minez
    block = blockchain.create_block(proof, previous_hash)
    
    block_hash = blockchain.proof_of_work(block)
    blockchain.chain_hashes.append(block_hash[0])
    response = {
                'message': 'Felicitari, tocmai ai minat un nou block!',
                'index': block['index'],
                'timestamp': block['timestamp'],
                'proof': block['proof'],
                'transactions':block['transactions'],
                'previous_hash': block['previous_hash'],
                'hash':block_hash[0]
                }
   
    # Golesc tranzactiile nodurilor conectate pentru evitarea conflictelor
    try:
        for node in blockchain.nodes:
            response_clear_peer_mempools = requests.get('http://{}/transactions/clear_transactions'.format(node))
    except:
        pass    
    return jsonify(response), 200

# Investitorul sau minerul genereaza o tranzactie care va fi adaugata ulterior la retea
@app.route('/transactions/generate_transaction', methods=['POST'])

def generate_transaction():
    json = request.get_json()
    transaction_keys = ['sender','sender_private_key','receiver','amount']
    if not all (key in json for key in transaction_keys):
        return 'A aparut o eroare cu datele primite.', 400
    sender = json['sender']
    sender_private_key = json['sender_private_key']
    receiver = json['receiver']
    amount = json['amount']
    
    transaction = Transaction(sender, sender_private_key, receiver, amount)
    transaction_result = {
                            'sender':transaction.sender,
                            'receiver':transaction.receiver,
                            'amount':transaction.amount
                         }

    response = {'transaction': transaction_result, 'signature': transaction.sign_transaction()}

    return jsonify(response), 200

# Adaugarea unei noi tranzactii la Blockchain
@app.route('/transactions/new_transaction',methods = ['POST'])

def new_transaction():
    json = request.get_json()
    transaction_keys =['sender','receiver','amount','signature']
    if not all (key in json for key in transaction_keys):
        return 'Elementele din tranzactie lipsesc.', 400
    transaction_result = blockchain.add_transaction(json['sender'],json['receiver'],json['amount'],json['signature'])

    if transaction_result is False:
        response = {
                    'message':'Tranzactie invalida!',
                   }
        return jsonify(response), 406
    elif isinstance(transaction_result, int):
        response = {
                    'message':'Aceasta tranzactie va fi adaugata la Block {0} '.format(transaction_result)
                   }
        return jsonify(response), 201 
    else:
        response = {
                    'message':'A aparut o eroare la procesarea tranzactiei.',
                   }
        return jsonify(response), 400 

# Iau toate tranzactiile din Mempool
@app.route('/transactions/get_transactions', methods=['GET'])

def get_transactions():
    transactions = blockchain.transactions

    response = {'transactions': transactions}
    return jsonify(response), 200

# Golesc tabela Mempool 
@app.route('/transactions/clear_transactions', methods=['GET'])

def clear_transactions():
    blockchain.transactions = []
    response = {
        'message': 'Tabela a fost golita cu succes.'
    }
    return jsonify(response), 200

@app.route('/chain/get_chain',methods = ['GET'])     

# Iau intreg lantul 
def get_chain():
    # hashes = []
    # for block in blockchain.chain:
    #     hash_operation = blockchain.proof_of_work(block)
    #     block_hash = hash_operation[0] # Iau hash-ul block-ului curent 
    #     hashes.append(block_hash)
    
    response = {
                'chain': blockchain.chain,  
                'hashes': blockchain.chain_hashes,
                'length' : len(blockchain.chain),
               }
  
    return jsonify(response), 200


# Verific daca reteaua este valida    
@app.route('/chain/is_valid',methods = ['GET'])     

def is_valid():
    is_valid = blockchain.is_chain_valid(blockchain.chain)
    if is_valid:
        response = {'message' : 'Reteaua este valida.'}
    else:
        response = {'message' : 'A existat o problema in validarea retelei.'}
    return jsonify(response), 200

# Sectiunea 3 - Decentralizarea retelei

# Conectarea la un nod nou
@app.route('/nodes/connect_nodes', methods = ['POST'])

def connect_nodes():
    json = request.get_json()   
    nodes = json.get('nodes')
    my_future_nodes = set() 
    if nodes is None:
        return "Nu sunt noduri noi de adaugat.",400
    node_copys = blockchain.nodes.copy()
    send_nodes = set()
    for node_copy in node_copys:
        send_nodes.add("http://{0}".format(node_copy)) 
    send_nodes.add(blockchain.get_host())
    # Trimit nodurile mele si nodul meu la cel cu care doresc  sa ma conectez

    for node in nodes:
        if urlparse(node).netloc not in blockchain.nodes and node != blockchain.get_host():
            response = requests.post('{0}/nodes/register_node'.format(node), json =  {"nodes" : list(send_nodes)})
            # Trimit la toate nodurile pe care le cunosc , nodul cu care doresc sa ma conectez
            response_nodes = response.json()
            if response_nodes['my_nodes'] is not None:
                for response_node in response_nodes['my_nodes']:
                    if "http://{0}".format(response_node) is not node and response_node != "127.0.0.1:{0}".format(blockchain.port):
                        response_sync_node = requests.post('http://{0}/nodes/register_node'.format(response_node),json = {"nodes" : list(send_nodes)} )
                        for my_node in blockchain.nodes:
                            response_my_node = requests.post('http://{0}/nodes/register_node'.format(my_node),json = { "nodes": ["http://{0}".format(response_node)] })  
                        my_future_nodes.add(response_node)
                        
            send_nodes.add(node)
            for my_node in blockchain.nodes:
                response_my_node = requests.post('http://{0}/nodes/register_node'.format(my_node),json = { "nodes": [node] })
            for my_future_node in my_future_nodes:
                if my_future_node != "127.0.0.1:{0}".format(blockchain.port):
                    blockchain.add_node("http://{0}".format(my_future_node))
       
            blockchain.add_node(node)
            
    replace_chain = blockchain.replace_chain()
    
    response  = {
                "message": "Toate nodurile din retea sunt sincronizate",
                "total_nodes":"Reteaua are acum {}".format(list(blockchain.nodes))
            }    
    return jsonify(response), 201


# Inregistrarea unui nou nod
@app.route('/nodes/register_node', methods = ['POST'])

def register_node():
    json = request.get_json()   
    nodes = json.get('nodes')
    if nodes is None:
        return "Nu sunt noduri noi de adaugat.",400
    my_nodes = blockchain.nodes.copy()
    response  = {
                    "my_nodes": list(my_nodes)
                }    
    for node in nodes:
        if node != blockchain.get_host():
            blockchain.add_node(node)
    return jsonify(response), 201


# Scoaterea unui nod din retea
@app.route('/nodes/remove_node/<node_url>', methods=['DELETE'])

def remove_node(node_url):
    if node_url == '' or node_url is None:
        return "Parametrul este invalid.",400

    remove_response = blockchain.remove_node(node_url)

    if remove_response:
        nodes = list(blockchain.nodes)
        response = {
            'message': 'Node-ul a fost scos cu succes din retea! Acum reteaua are urmatoarele noduri: ',
            'all_nodes': nodes
        }
        return jsonify(response), 200
    else:
         return "Nodul furnizat nu se afla in retea la momentul actual.",400

# Iau toate nodurile conectate
@app.route('/nodes/get_nodes', methods=['GET'])

def get_nodes():
    nodes = list(blockchain.nodes)
    response = {'nodes': nodes}
    return jsonify(response), 200

# Inlocuirea retelei cu cel  mai lung lang daca este nevoie
@app.route('/nodes/replace_chain',methods = ['GET'])     

def replace_chain():
    is_chain_replaced = blockchain.replace_chain()
    if is_chain_replaced:
        response = {
                    'message' : 'Nodul are diferite lanturi asa ca au fost inlocuite cu cel mai lung.',
                    'new_chain':blockchain.chain
                    }
    else:
        response = {
                    'message' : 'Lantul deja este cel mai lung.',
                    'actual_chain':blockchain.chain
                    }
    return jsonify(response), 200


# Rularea aplicatiei
app.run(host = '0.0.0.0',port = blockchain.port)     
        
        