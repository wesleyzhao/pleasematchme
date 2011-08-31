import MySQLdb

def connect():
	con = MySQLdb.connect(host='localhost',user='pleasematch',passwd='PleasePass123',db='pleasematch')
	return con.cursor()

cur = connect()
cur.execute("SELECT school_id FROM schools");
a = cur.fetchall()
ids = [x[0] for x in a]

def do(list):
	for id in list:
		id = str(id)
		cur = connect()
		cur.execute("SELECT * FROM people WHERE high_school_id='%s' OR college_school_id='%s' OR other_school_id='%s'"%(id,id,id))
		count = len(cur.fetchall())
		cur.execute("UPDATE schools SET school_count='%s' WHERE school_id='%s'"%(count,id))
		print 'OK: '+id
		
do (ids)
		