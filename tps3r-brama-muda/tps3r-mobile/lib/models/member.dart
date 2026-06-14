// lib/models/member.dart (UPDATE)
class Member {
  final int id;
  final String name;
  final String role;
  final bool active;
  final String avatarInitial;
  final String? phone;
  final String? email;

  Member({
    this.id = 0,
    required this.name,
    required this.role,
    this.active = true,
    required this.avatarInitial,
    this.phone,
    this.email,
  });
}
