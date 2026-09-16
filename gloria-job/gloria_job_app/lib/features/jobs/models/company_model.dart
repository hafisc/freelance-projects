class CompanyModel {
  final int id;
  final String name;
  final String? email;
  final String? phone;
  final String? address;
  final String? website;
  final String? description;
  final String? logo;
  final String? industry;
  final String? picName;
  final String? picPhone;
  final String? logoUrl;

  CompanyModel({
    required this.id,
    required this.name,
    this.email,
    this.phone,
    this.address,
    this.website,
    this.description,
    this.logo,
    this.industry,
    this.picName,
    this.picPhone,
    this.logoUrl,
  });

  factory CompanyModel.fromJson(Map<String, dynamic> json) {
    return CompanyModel(
      id: json['id'],
      name: json['name'] ?? '',
      email: json['email'],
      phone: json['phone'],
      address: json['address'],
      website: json['website'],
      description: json['description'],
      logo: json['logo'],
      industry: json['industry'],
      picName: json['pic_name'],
      picPhone: json['pic_phone'],
      logoUrl: json['logo_url'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'phone': phone,
      'address': address,
      'website': website,
      'description': description,
      'logo': logo,
      'industry': industry,
      'pic_name': picName,
      'pic_phone': picPhone,
    };
  }
}
