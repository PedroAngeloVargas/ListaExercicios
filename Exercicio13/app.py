import datetime
import zoneinfo 

fuso_horario_sp = zoneinfo.ZoneInfo("America/Sao_Paulo")

data_e_hora_atuais = datetime.datetime.now(fuso_horario_sp)

formato_br = data_e_hora_atuais.strftime("%d/%m/%Y %H:%M:%S")

print("Data e hora no Brasil (Fuso horario de Brasilia):", formato_br)