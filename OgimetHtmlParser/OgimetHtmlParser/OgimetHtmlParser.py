import urllib.request
from html.parser import HTMLParser
import sys
import datetime

def ClearParser1Data(MyParser):
    MyParser.ParseStationIndex = 0
    MyParser.IndexTableFound = 0
    MyParser.StationIndex = '0'

def ClearParser2Data(MyParser2):
    MyParser2.ParseLongitude = 0
    MyParser2.ParseLatitude = 0
    MyParser2.ParseAltitude = 0
    MyParser2.IndexTableFound = 0
    MyParser2.IndexRowFound = 0
    MyParser2.Latitude = '0'
    MyParser2.Longitude = '0'
    MyParser2.Altitude = '0'

def ClearParser3Data(MyParser3):
    MyParser3.IndexRowFound = 0
    MyParser3.DataFound = 0
    MyParser3.DateParsed = 0
    MyParser3.Date = '0'
    MyParser3.TMAX = 0.0
    MyParser3.TMIN = 0.0
    MyParser3.TMID = 0.0
    MyParser3.TAVG = 0.0
    MyParser3.HAVG = 0.0
    MyParser3.WDIR = 0.0
    MyParser3.WINT = 0.0
    MyParser3.WGUS = 0.0
    MyParser3.PRES = 0.0
    MyParser3.PREC = 0.0
    MyParser3.TCLD = 0.0
    MyParser3.LCLD = 0.0
    MyParser3.SUN = 0.0
    MyParser3.SVIS = 0.0

def ClearParserData():
    MyParser.ParseStationIndex = 0
    MyParser.IndexTableFound = 0
    MyParser.StationIndex = '0'

    MyParser2.ParseLongitude = 0
    MyParser2.ParseLatitude = 0
    MyParser2.ParseAltitude = 0
    MyParser2.IndexTableFound = 0
    MyParser2.IndexRowFound = 0
    MyParser2.Latitude = '0'
    MyParser2.Longitude = '0'
    MyParser2.Altitude = '0'

    MyParser3.IndexTableFound = 0
    MyParser3.IndexRowFound = 0
    MyParser3.DataFound = 0
    MyParser3.DateParsed = 0
    MyParser3.Date = '0'
    MyParser3.TMAX = 0.0
    MyParser3.TMIN = 0.0
    MyParser3.TMID = 0.0
    MyParser3.TAVG = 0.0
    MyParser3.HAVG = 0.0
    MyParser3.WDIR = 0.0
    MyParser3.WINT = 0.0
    MyParser3.WGUS = 0.0
    MyParser3.PRES = 0.0
    MyParser3.PREC = 0.0
    MyParser3.TCLD = 0.0
    MyParser3.LCLD = 0.0
    MyParser3.SUN = 0.0
    MyParser3.SVIS = 0.0
    MyParser3.DataID = IdOfFirstData
    MyParser3.DataStationID = IdOfFirstDataStation

IdOfLocation = str(sys.argv[1])
IdOfFirstData = int(sys.argv[2])
IdOfFirstDataStation = int(sys.argv[3])
IdOfStation = str(sys.argv[4])
NameOfStation = str(sys.argv[5])
LastDataDate = datetime.datetime.strptime( str(sys.argv[6]),"%Y-%m-%d")
NowDateTime = datetime.datetime.now()
NumberOfDays = (NowDateTime - LastDataDate).days
LocationOutputFile = open(NameOfStation+'Location.txt','w')
DataOutputFile = open(NameOfStation+'Data.txt','w')

def SaveLocationToFile(p_MyParser2):
    LocationOutputFile.write(IdOfLocation+' ')
    LocationOutputFile.write(p_MyParser2.Latitude+' ')
    LocationOutputFile.write(p_MyParser2.Longitude+' ')
    LocationOutputFile.write(p_MyParser2.Altitude+' ')
    LocationOutputFile.write(IdOfStation+'\n')

def SaveDataToFile(p_MyParser3, p_DataCode, p_DataValue, p_DataID,p_StationDataID):
    DataOutputFile.write(str(p_DataID)+' ')
    DataOutputFile.write(str(p_StationDataID)+' ')
    DataOutputFile.write(p_MyParser3.Date+' ')
    DataOutputFile.write(str(NowDateTime.hour)+':'+str(NowDateTime.minute)+':'+str(NowDateTime.second)+' ')
    DataOutputFile.write(p_DataCode+' '+str(p_DataValue)+' '+IdOfStation+'\n')
    

class MyHTMLParser(HTMLParser):
    def handle_starttag(self, tag, attrs):
        if(self.IndexTableFound==1 and tag == 'a' and attrs[0][0]== 'href'):
            self.ParseStationIndex=1
        if((tag=='table') and (attrs[0][0]=='border') and (attrs[0][1]=='2')):
            self.IndexTableFound=1
    def handle_data(self, data):
        if(self.ParseStationIndex==1):
            self.StationIndex=data
            self.ParseStationIndex=0
            self.IndexTableFound=0

class MyHTMLParser2(HTMLParser):
    def handle_starttag(self, tag, attrs):
        if((tag=='table') and (attrs[0][0]=='border') and (attrs[0][1]=='2')):
            self.IndexTableFound=1
        if((tag=='h4') and self.IndexTableFound):
            self.IndexRowFound=1
        if((tag=='font') and (self.IndexRowFound)):
            self.ParseLatitude=1
            self.IndexRowFound=0
        elif((tag=='font') and (self.ParseLatitude)):
            self.ParseLongitude=1
            self.ParseLatitude=0
        elif((tag=='font') and (self.ParseLongitude)):
            self.ParseAltitude=1
            self.ParseLongitude=0
            
    def handle_data(self, data):
        if(self.ParseLatitude  and (self.Latitude=='0')):
            self.Latitude=data
        elif(self.ParseLongitude and (self.Longitude=='0')):
            self.Longitude=data
        elif(self.ParseAltitude and (self.Altitude=='0')):
            self.Altitude=data
            self.ParseAltitude=0
            SaveLocationToFile(self)
            dupa=1

class MyHTMLParser3(HTMLParser):
    def handle_starttag(self, tag, attrs):
        if((tag=='table') and (attrs[0][0]=='align') and (attrs[0][1]=='center')):
            self.IndexTableFound=1
        if((tag=='a') and self.IndexTableFound):
            self.IndexRowFound=1
            self.DataStationID+=1
            self.DataFound=0
        if((tag=='td') and self.Date!='0' and self.DataFound==0):
            self.DataFound=1
    def handle_data(self, data):
        if(self.IndexRowFound and self.Date == '0'):
            self.Date = data
            self.Date = self.Date.replace('/','-')
            self.Date = str(NowDateTime.year)+'-'+self.Date
            self.IndexRowFound=0
        elif(self.Date != '0' and self.TMAX == 0 and self.DataFound):
            self.DataID+=1
            self.TMAX=data
            self.DataFound=0
            SaveDataToFile(self,"TMAX",self.TMAX,self.DataID,self.DataStationID)
        elif(self.TMAX != 0 and self.TMIN == 0 and self.DataFound):
            self.DataID+=1
            self.TMIN=data
            self.DataFound=0
            SaveDataToFile(self,"TMIN",self.TMIN,self.DataID,self.DataStationID)
        elif(self.TMIN != 0 and self.TMID == 0 and self.DataFound):
            self.DataID+=1
            self.TMID=data
            self.DataFound=0
            SaveDataToFile(self,"TMID",self.TMID,self.DataID,self.DataStationID)
        elif(self.TMID != 0 and self.TAVG == 0 and self.DataFound):
            self.DataID+=1
            self.TAVG=data
            self.DataFound=0
            SaveDataToFile(self,"TAVG",self.TAVG,self.DataID,self.DataStationID)
        elif(self.TAVG != 0 and self.HAVG == 0 and self.DataFound):
            self.DataID+=1
            self.HAVG=data
            self.DataFound=0
            SaveDataToFile(self,"HAVG",self.HAVG,self.DataID,self.DataStationID)
        elif(self.HAVG != 0 and self.WDIR == 0 and self.DataFound):
            self.WDIR=data
            self.DataFound=0
        elif(self.WDIR != 0 and self.WINT == 0 and self.DataFound):
            self.DataID+=1
            self.WINT=data
            self.DataFound=0
            SaveDataToFile(self,"WINT",self.WINT,self.DataID,self.DataStationID)
        elif(self.WINT != 0 and self.WGUS == 0 and self.DataFound):
            self.DataID+=1
            self.WGUS=data
            self.DataFound=0
            SaveDataToFile(self,"WGUS",self.WGUS,self.DataID,self.DataStationID)
        elif(self.WGUS != 0 and self.PRES == 0 and self.DataFound):
            self.DataID+=1
            self.PRES=data
            self.DataFound=0
            SaveDataToFile(self,"PRES",self.PRES,self.DataID,self.DataStationID)
        elif(self.PRES != 0 and self.PREC == 0 and self.DataFound):
            self.DataID+=1
            self.PREC=data
            self.DataFound=0
            SaveDataToFile(self,"PREC",self.PREC,self.DataID,self.DataStationID)
        elif(self.PREC != 0 and self.TCLD == 0 and self.DataFound):
            self.DataID+=1
            self.TCLD=data
            self.DataFound=0
            SaveDataToFile(self,"TCLD",self.TCLD,self.DataID,self.DataStationID)
        elif(self.TCLD != 0 and self.LCLD == 0 and self.DataFound):
            self.DataID+=1
            self.LCLD=data
            self.DataFound=0
            SaveDataToFile(self,"LCLD",self.LCLD,self.DataID,self.DataStationID)
        elif(self.LCLD != 0 and self.SUN == 0 and self.DataFound):
            self.DataID+=1
            self.SUN=data
            self.DataFound=0
            SaveDataToFile(self,"SUNH",self.SUN,self.DataID,self.DataStationID)
        elif(self.SUN != 0 and self.SVIS == 0 and self.DataFound):
            self.DataID+=1
            self.SVIS=data
            self.DataFound=0
            SaveDataToFile(self,"SVIS",self.SVIS,self.DataID,self.DataStationID)
            ClearParser3Data(self)


OgimetHTML = []
MyParser = MyHTMLParser()
MyParser2 = MyHTMLParser2()
MyParser3 = MyHTMLParser3()

ClearParserData()


with urllib.request.urlopen('http://www.ogimet.com/display_stations.php?lang=en&tipo=AND&isyn=&oaci=&nombre='+NameOfStation+'&estado=&Send=Send') as URLresponse:
    OgimetHTML = str(URLresponse.read())
MyParser.feed(OgimetHTML)

with urllib.request.urlopen('http://www.ogimet.com/cgi-bin/gsynres?lang=en&ord=REV&ndays='+
                                str(NumberOfDays)+'&ano='+
                                str(NowDateTime.year)+'&mes='+
                                str(NowDateTime.month)+'&day='+
                                str(NowDateTime.day)+'&hora='+
                                str(NowDateTime.hour)+'&ind='+
                                MyParser.StationIndex) as URLresponse2:
    OgimetHTML2 = str(URLresponse2.read())
MyParser2.feed(OgimetHTML2)

MyParser3.feed(OgimetHTML2)
