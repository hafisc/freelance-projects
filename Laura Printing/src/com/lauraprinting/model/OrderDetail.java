package com.lauraprinting.model;

public class OrderDetail {
    private int id;
    private int orderId;
    private int serviceId;
    private String serviceName; // helper for display
    private String serviceUnit; // helper for display
    private int qty;
    private double price;
    private double subtotal;

    public OrderDetail() {}

    public OrderDetail(int id, int orderId, int serviceId, String serviceName, String serviceUnit, int qty, double price, double subtotal) {
        this.id = id;
        this.orderId = orderId;
        this.serviceId = serviceId;
        this.serviceName = serviceName;
        this.serviceUnit = serviceUnit;
        this.qty = qty;
        this.price = price;
        this.subtotal = subtotal;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getOrderId() {
        return orderId;
    }

    public void setOrderId(int orderId) {
        this.orderId = orderId;
    }

    public int getServiceId() {
        return serviceId;
    }

    public void setServiceId(int serviceId) {
        this.serviceId = serviceId;
    }

    public String getServiceName() {
        return serviceName;
    }

    public void setServiceName(String serviceName) {
        this.serviceName = serviceName;
    }

    public String getServiceUnit() {
        return serviceUnit;
    }

    public void setServiceUnit(String serviceUnit) {
        this.serviceUnit = serviceUnit;
    }

    public int getQty() {
        return qty;
    }

    public void setQty(int qty) {
        this.qty = qty;
        this.subtotal = this.price * qty;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
        this.subtotal = price * this.qty;
    }

    public double getSubtotal() {
        return subtotal;
    }

    public void setSubtotal(double subtotal) {
        this.subtotal = subtotal;
    }
}
