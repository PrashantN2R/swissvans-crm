# SwissVans CRM - Foundation Blueprint (2027 Reset)

## 📌 Project Overview
This repository contains the architectural specifications for the SwissVans CRM. The system is built on **vehicle-first logic**, prioritizing clean data structures and long-term asset tracking over temporary sales features.

## 🏗 Core Architectural Principles
- **Vehicle-First:** The `Vehicle` is the permanent asset and the center of the CRM.
- **Immutable Transactions:** A `Sale` is a point-in-time event. Once marked "Completed," it cannot be edited.
- **Relationship Persistence:** Customers are long-lived entities independent of individual sales.
- **Lead Isolation:** Leads are temporary entry points and never "own" a vehicle.
- **No Automation/AI:** This phase focuses strictly on clean structure.

---

## 🛠 Module Specifications

### 1. Customer/Company Module
- **Purpose:** Independent long-lived relationship records.
- **List View:** Name/Company, Primary Contact, Linked Vehicles (derived), Linked Sales (derived).
- **Detail Page:** Summary, contact info, notes, and read-only history.
- **Rule:** Customers are never deleted. No lifecycle or tiering logic.

### 2. Vehicle Module (Core)
- **Purpose:** The permanent "Source of Truth" for every asset.
- **List View:** Reg, VIN, Model, Status, Current Owner (derived).
- **Detail Page:** Reg, VIN, CAP, Model, Year. Shows derived Current Owner and a read-only ownership timeline.
- **Rule:** Ownership is derived from the latest completed sale. No stock list or pricing logic.

### 3. Sale / Deal Module
- **Purpose:** Immutable link between one Customer and one Vehicle.
- **List View:** Deal ID, Customer, Vehicle, Type, Status, Salesperson.
- **Detail Page:** Financials (Price, Margin, Commission) and Status.
- **Rule:** Completed deals are locked (Immutable).

### 4. Lead Intake & Conversion
- **Purpose:** Gateway for enquiries.
- **Flow:** Convert Lead → Select/Create Customer → Select/Create Vehicle → Draft Deal.
- **Rule:** Leads become read-only post-conversion.

### 5. Sales Pipeline (View Only)
- **Stages:** Enquiry → Quoted → Negotiation → Ready → Completed.
- **Rule:** Displays links to leads/draft deals only. No data creation here.

### 6. Vehicle Transfer & Post-Sales
- **Function:** Reassigns a vehicle to a new customer via a new sale record.
- **Post-Sales:** Read-only historical context (ownership changes, past sales, notes).

---

## 🚫 Strictly Out of Scope (Do Not Implement)
- AI features or Forecasting.
- Customer Portals or Automated Workflows.
- Used vehicle tools or Part-Exchange (PX) logic.

## 🚀 Implementation Steps for Laravel
1. **Schema:** Design `vehicles`, `customers`, and `deals` tables. Use a `uuid` for deals.
2. **Models:** Implement `getCurrentOwnerAttribute()` on the `Vehicle` model querying the latest `completed` deal.
3. **Immutability:** Create a `DealPolicy` to prevent `update` or `delete` actions once `status == 'completed'`.
4. **Service:** Build a `LeadConversionService` to handle the data transition logic cleanly.
5. **UI:** Create the 5 key screens: Vehicle Detail, Deal Flow, Completed Deal, Lead Conversion, and Customer Detail.
