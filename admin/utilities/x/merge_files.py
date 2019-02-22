#!/usr/bin/python
"""
Merge two SQL files.
Find the line in each file beginning with the same first two fields.
Keep the longer field for each field in the two lines.
"""

file1 = '/drop/share/TristanBruck/database_backups/elloracaves_20121217_TB_caves_30_32.sql'
file2 = '/drop/share/TristanBruck/database_backups/elloracaves_20121219_AK_earlyAM.sql'
out_file = '/drop/share/TristanBruck/database_backups/elloracaves_20121219_AK_TB_merged.sql'

break_string = "INSERT INTO `plans`"

fh1 = open(file1, 'r')
lines1 = fh1.read().split('\n')

fh2 = open(file1, 'r')
lines2 = fh2.read().split('\n')

count2 = 0
for line1 in lines1:
	if break_string in line1:
		break
	if line1.startswith('('):
		line1 = line1[1:-2].split(',')
		field1_line1 = line1[0].strip()
		field2_line1 = line1[1].strip()
		
		for iline2, line2 in enumerate(lines2):
			if iline2 > count2:
				if break_string in line2:
					break
				if line2.startswith('('):
					line2 = line2[1:-2].split(',')
					field1_line2 = line2[0].strip()
					field2_line2 = line2[1].strip()
	
					if field1_line2 == field1_line1 and \
					   field2_line2 == field2_line1:

						count2 = iline2						
						for ifield, field_line1 in enumerate(line1):
							#print('')
							#print(line1)
							#print(line2)
							field_line1 = field_line1.strip()
							field_line2 = line2[ifield].strip()
							#print(field_line1, field_line2)
							if len(field_line1) < len(field_line2):
								print(field_line2,field_line1)
							elif len(field_line2) < len(field_line1):
								print(field_line1,field_line2)
        
