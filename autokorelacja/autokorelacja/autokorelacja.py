import mysql.connector
from mysql.connector import errorcode
from matplotlib import pyplot
from cycler import cycler
import sys

#obliczenie sredniej
def average(p_values):
    sum = 0
    for val in p_values:
        sum = sum + val 
    return sum/len(p_values)

def autocorrelation(p_values, p_offset):
    numerator = int()
    denominator = 0
    atcrr = list()
    avrg = average(p_values)
    p_offset = p_offset + 1
    #ustawiamy offset na maksymalny jesli przekracza liczbe elementow
    if p_offset > len(p_values):
        p_offset = len(p_values)

    for val in p_values:
        denominator += (val - avrg)**2

    for m in range(0, p_offset):       
        numerator = 0
        for n in range(0, len(p_values) - m):
             numerator = numerator + (p_values[n] - avrg)*(p_values[n + m] - avrg)
             
        atcrr.append(numerator/denominator)
    return atcrr
        


StationName = sys.argv[1]
DataType = list()

connect = mysql.connector.connect(user="root", password="", host="localhost", database="analizadanychpogodowych")

cursor = connect.cursor()

query = ("SELECT `StationID` FROM `StacjePogodowe` WHERE `NazwaStacjiPogodowej`='"+StationName+"'")
cursor.execute(query)
StationID =str(cursor.fetchone()[0])

fig = pyplot.figure(figsize=(20,10))
title = "Wykres autokorelacji "
filename="./autokorelacja_"+StationName


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
    offset = round(len(values)*0.8)
    my_autocorrelation = autocorrelation(values, offset)
    my_x_axis = list()
    for k in range(0, len(my_autocorrelation)):
        my_x_axis.append(k)
    
    #if i == 2:
    #    for bla in my_autocorrelation:
    #        print("%.2f" % bla)
    pyplot.rc('axes', prop_cycle=(cycler('color', ['r', 'g', 'b', 'y']) +
                           cycler('marker', ['o', 'x', '^', 'v']) +
                           cycler('linestyle', [' ', ' ', ' ', ' '])))
    pyplot.plot(my_x_axis,my_autocorrelation,label=DataType[i-2])
    title+=DataType[i-2]+", "
    filename+="_" + DataType[i-2]

fig.tight_layout()
fig.subplots_adjust(bottom=0.1)
fig.subplots_adjust(top=0.9)
title+="z maksymalnym opoznieniem: " + str(offset) + "\n w zakresie dat " + str(dates[0]) + " - " + str(dates[len(dates)-1])
filename+="plot.png"
pyplot.grid(which='both')
pyplot.legend(loc='upper right')
pyplot.xticks(my_x_axis)
pyplot.title(title)
pyplot.savefig(filename)