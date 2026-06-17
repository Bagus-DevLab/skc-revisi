String rupiah(int value) {
  final chars = value.toString().split('').reversed.toList();
  final chunks = <String>[];
  for (var i = 0; i < chars.length; i += 3) {
    chunks.add(chars.skip(i).take(3).toList().reversed.join());
  }
  return 'Rp ${chunks.reversed.join('.')}';
}
