#CS 340 Database App

### Totally Not Vampires: 
*A Non-Profit Blood Donation Organization*

### Outline:
  This database will be used to organize the hypothetical *Totally not Vampires* network of blood donation clinics. Due to the nature of the medical field it is vital that all aspects of the organization are properly tracked and maintained between donors, blood, employees, and clinics. The database will keep track of donor information, number and type of blood specimens, clinic locations, and the employees needed to manage demand.

  Donors can come to any of our clinics and donate one unit of their blood specimen. Donor information will be accurately recorded by clinic employees and entered into the database. It is vital to maintain accurate information as blood samples must be linked to a donor. Each clinic is self-sustaining and can test blood samples on site for blood type and purity. Each clinic has a staff of employees with specific roles needed to accomplish our organizational goals. 

### Database Outline:
  1.	**Donors:**
    *	Donors are tracked by a unique donor ID.
    *	Personal information includes first name, last name, age, and sex.
      *	The combination of the Donor’s first and last name must be unique.
      *	Donor’s sex is not a mandatory field. * 
    *	Donors must be at least 17 years of age.
    *	Donors can donate at any clinic any number of times.

  2.	**Blood:**
    *	Blood is tracked by a unique ID.
    *	BloodType is how the blood is categorized: (A+/-, B+/-, AB+/-, O+/-, N/A). 
      *	N/A refers to blood that has not been processed yet.
    *	Status refers to the state of the blood: (pure, N/A, impure).
      *	N/A refers to blood that has not been processed yet.
    *	Donor_id is a FK which references the ID of the Donor.
      *	Blood specimens must have a donor
      *	Clinic_id is a FK which references the ID of the Clinic that stores the blood.
      *	Blood specimens must be stored at one clinic.
    *	DonateDate is the date the blood sample was received. 

  3.	**Clinic:**
    *	Clinics are tracked by unique clinic ID.
    *	Each clinic has a name and location.
      *	The combination of the clinic’s name and location must be unique

  4.	**Employees:**
    *	Employees are tracked by unique Employee ID.
    *	Clinic_id is a FK which references the Clinic ID which they work at.
      *	Employees must work at a single Clinic.
    *	Personal information includes Fname, Lname, and sex.
      *	The combination of an employee’s first and last name must be unique

  5.	**Certifications:**
    *	Certifications are tracked by a unique Certification ID.
    *	Title is the type of certification: (Supervisor, phlebotomist, volunteer).
      *	Each title must be unique.

  6. **Certified_As:**
    *	Many-to-many relationship between Employees and their Certifications
      *	Emp_id is a FK which references Employee ID
      *	Cert_id is a FK which references Certifications ID
    *	DateOfCert is the date which the certification was acquired.

*All fields have a NOT NULL constraint unless otherwise specified.

### ER Diagram of Database:

![ER Diagram](https://cloud.githubusercontent.com/assets/14823725/15612104/078a4df4-23f3-11e6-844f-cd5f66cae230.png)

### Database Schema
![Database Schema](https://cloud.githubusercontent.com/assets/14823725/15612103/078a2dd8-23f3-11e6-846d-e5b9ca22b3bf.png)
