select jobProfitID, jobCustomerID, jitProductID, prdCategoryID, SUM(CASE WHEN MONTH(jobShipmentDate)=1 THEN jitQuantity ELSE 0 END) as 'Jan'
, SUM(CASE WHEN MONTH(jobShipmentDate)=2 THEN jitQuantity ELSE 0 END) as 'Feb'
, SUM(CASE WHEN MONTH(jobShipmentDate)=3 THEN jitQuantity ELSE 0 END) as 'Mar'
, SUM(CASE WHEN MONTH(jobShipmentDate)=4 THEN jitQuantity ELSE 0 END) as 'Apr'
, SUM(CASE WHEN MONTH(jobShipmentDate)=5 THEN jitQuantity ELSE 0 END) as 'May'
, SUM(CASE WHEN MONTH(jobShipmentDate)=6 THEN jitQuantity ELSE 0 END) as 'Jun'
, SUM(CASE WHEN MONTH(jobShipmentDate)=7 THEN jitQuantity ELSE 0 END) as 'Jul'
, SUM(CASE WHEN MONTH(jobShipmentDate)=8 THEN jitQuantity ELSE 0 END) as 'Aug'
, SUM(CASE WHEN MONTH(jobShipmentDate)=8 THEN jitQuantity ELSE 0 END) as 'Sep'
, SUM(CASE WHEN MONTH(jobShipmentDate)=10 THEN jitQuantity ELSE 0 END) as 'Oct'
, SUM(CASE WHEN MONTH(jobShipmentDate)=11 THEN jitQuantity ELSE 0 END) as 'Nov'
, SUM(CASE WHEN MONTH(jobShipmentDate)=12 THEN jitQuantity ELSE 0 END) as 'Dec'
,SUM(jitActIncome_rep)/SUM(jitQuantity) as selling_rate
,SUM(jitActCost_rep)/SUM(jitQuantity) as buying_rate
FROM tbl_job_item 
JOIN tbl_job on jobID=jitJobID
LEFT JOIN vw_product ON prdID=jitProductID
where DATEDIFF(NOW(),jobShipmentDate)<=365 and jobStatusID in(30,40) and tbl_job.jobMasterID IS NULL
group by jobProfitID, jobCustomerID, jitProductID
order by jobProfitID, jobCustomerID, prdCategoryID