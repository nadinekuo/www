#!/usr/bin/perl

use strict;
use warnings;

use LWP::Simple;

# some constants (do not use locale specific values since the server is in the
# US no matter what my locale is).
my @months = ("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
my $url_fmt = "http://lists.einsteintoolkit.org/pipermail/users/%04d-%s/date.html";

# these hold the list of emails and the root of the conversations
our (%emails);

# get emails logs for the three months braketing the current one
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime();
my $m = +1;
while(1) {
  my $monthyear = $year * 12 + $mon + $m;
  my $monthname = $months[$monthyear % 12];
  my $fullyear = 1900 + int($monthyear / 12);
  my $url = sprintf($url_fmt, $fullyear, $monthname);
  my $content = get($url);
  my $only_existing = ($m < -1);
  my $num_found = parse_content($content, $url, $only_existing) if $content;
  # continue to earlier months until we have braked the current month and no
  # more emails with known subjects are found
  if($m > -1 or $num_found > 0) {
    $m -= 1;
  } else {
    last;
  }
} 

# if there is an email thread with either only a single post or where the last
# poster is the original poster then they are candidates for unanswered emails
print "<ul>\n";
foreach my $key (sort sort_by_date (keys %emails)) {
  my @authors = @${$emails{$key}->{senders}};
  my $num_authors = scalar @authors;
  my @segments = @${$emails{$key}->{segments}};
  my $num_segments = scalar @segments;
  if($num_authors == 1 or $authors[0] eq $authors[-1]) {
    if($num_authors == 1 and 
       $key =~ m/\[Users\] meeting minutes /i) {
     next;
    }
    my $content = get($segments[-1]);
    my $date = "unknown";
    if ($content and $content =~ m!<I>\w\w\w (\w\w\w (\d|\s)\d (\d|\s)\d:\d\d:\d\d \w\w\w \d\d\d\d)</I>!) {
      $date = $1;
    }
    print "<li><tt style='white-space:pre;'>".sanitize($date)."</tt>".sanitize(" $key ($authors[0])").": <a href='".url(${$emails{$key}->{root}})."'>root</a>";
    for (my $i = 1 ; $i < $num_segments-1 ; $i++) {
      print " <a href='".url($segments[$i])."'>[$i]</a>";
    }
    print " <a href='".url($segments[-1])."'>tail</a>" if $num_authors > 1;
    print "</li>\n";
  }
}
print "</ul>\n";

sub parse_content {
  my ($content, $monthurl, $only_existing) = @_;
  our (%emails);
  die "Incorrect number of arguments ".scalar @_.". Expected 3." unless scalar @_ == 3;

  $monthurl =~ s!/[^/]*$!!;

  my @lines = split /\n/,$content;
  my $subject = undef;
  my $num_found = 0;
  foreach (@lines) {
    if(/^<LI><A HREF="(\d*\.html)">(.*)/) {
      my $url = $1;
      $subject = $2;
      # apparently some subjects have random whitespace (maybe line breaking?)
      $subject =~ s/\s\s*/ /g;
      if(not exists $emails{$subject} and not $only_existing) {
        $emails{$subject} = {};
        ${$emails{$subject}->{senders}} = [];
        ${$emails{$subject}->{segments}} = [];
        ${$emails{$subject}->{root}} = $monthurl . "/" . $url;
      }
      if(exists $emails{$subject}) {
        push @${$emails{$subject}->{segments}}, ($monthurl . "/" . $url);
        $num_found += 1;
      }
    } elsif(/^<I>(.*)/) {
      my $sender = $1;
      if(exists $emails{$subject}) {
        push @${$emails{$subject}->{senders}}, ($sender);
      }
    }
  }

  return $num_found;
}

sub sanitize {
  # a very trivial text sanitizer to remove all html tags
  my ($text) = @_;
  $text =~ s/</\&lt;/g;
  $text =~ s/</\&gt;/g;
  return $text;
}

sub url {
  # a very simple URL sanitizer
  my ($url) = @_;
  if($url =~ s![^a-zA-Z0-9/_:.-]!!g) {
    warn "Invalid characcters in url $_[0]";
  }
  return $url;
}

sub sort_by_date($$) {
  # reverse sort an email in the emails hash by email series number of its tail
  my ($a, $b) = @_;
  our (%emails);
  my (@segments_a) = @${$emails{$a}->{segments}};
  my (@segments_b) = @${$emails{$b}->{segments}};
  my ($id_a, $id_b) = (undef, undef);
  $id_a = $1 if($segments_a[-1] =~ m!/([^/]*)\.html!);
  $id_b = $1 if($segments_b[-1] =~ m!/([^/]*)\.html!);
  if($id_a and $id_b) {
    return -($id_a cmp $id_b);
  } elsif($id_a) {
    return +1;
  } elsif($id_b) {
    return -1;
  } else {
    # I do not think I can really get here
    return 0;
  }
}

1;
