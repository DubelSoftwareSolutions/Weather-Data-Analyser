import mysql.connector
from mysql.connector import errorcode
import pandas
from matplotlib import pyplot
from cycler import cycler
import sys


StationName = sys.argv[1]
DataType = list()

connect = mysql.connector.connect(user="root", password="", host="localhost", database="analizadanychpogodowych")

cursor = connect.cursor()

query = ("SELECT `StationID` FROM `StacjePogodowe` WHERE `NazwaStacjiPogodowej`='"+StationName+"'")
cursor.execute(query)
StationID =str(cursor.fetchone()[0])

fig = pyplot.figure(figsize=(20,10))
title = "Wykres zaleznosci "
filename="./"+StationName
for i in range(2, len(sys.argv)):
    DataType.append(sys.argv[i])
    query = ("SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `KodPomiaru`='"+DataType[i-2]+"' AND `StationID`="+StationID+" ORDER BY `DataPomiaru`")
    cursor.execute(query)
    result = cursor.fetchall()
    dates = list()
    values = list()
    for currentTuple in result:
        dates.append(currentTuple[0])
        values.append(currentTuple[1])
    
    pyplot.rc('axes', prop_cycle=(cycler('color', ['r', 'g', 'b', 'y']) +
                           cycler('marker', ['o', 'x', '^', 'v']) +
                           cycler('linestyle', [' ', ' ', ' ', ' '])))
    pyplot.plot(dates,values,label=DataType[i-2])
    title+=DataType[i-2]+", "
    filename+=DataType[i-2]

fig.tight_layout()
fig.subplots_adjust(bottom=0.2)
title+="w czasie"
filename+="plot.png"
pyplot.grid(which='both')
pyplot.legend(loc='upper left')
pyplot.xticks(rotation=70)
pyplot.xticks(dates)
pyplot.title(title)
pyplot.savefig(filename)