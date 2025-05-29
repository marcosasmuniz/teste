-- Customers Table
CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    asaas_customer_id VARCHAR(255) UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    whatsapp_number VARCHAR(50) NOT NULL,
    cpf_cnpj VARCHAR(20) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Invoices Table
CREATE TABLE invoices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    asaas_invoice_id VARCHAR(255) UNIQUE NOT NULL,
    customer_id INT,
    due_date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    payment_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    INDEX idx_customer_id (customer_id),
    INDEX idx_status (status),
    INDEX idx_due_date (due_date)
);

-- Message Templates Table
CREATE TABLE message_templates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    type VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sent Messages Table
CREATE TABLE sent_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    invoice_id INT,
    message_template_id INT,
    message_content_sent TEXT NOT NULL,
    recipient_whatsapp_number VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    whaticket_message_id VARCHAR(255),
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    error_message TEXT,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id),
    FOREIGN KEY (message_template_id) REFERENCES message_templates(id),
    INDEX idx_customer_id_sent (customer_id),
    INDEX idx_invoice_id_sent (invoice_id),
    INDEX idx_status_sent (status)
);

-- Application Logs Table
CREATE TABLE application_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    context JSON
);
